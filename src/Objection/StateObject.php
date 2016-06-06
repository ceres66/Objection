<?php
namespace Objection;


use Objection\Exceptions\PropertyNotFoundException;


abstract class StateObject extends LiteObject 
{
	private $modified = [];
	
	
	/**
	 * @param array|string|bool $filter
	 * @param array|string|bool $exclude
	 * @return array|null
	 */
	private function getPropertyNamesFilter($filter, $exclude) 
	{
		if ($exclude) 
		{
			if (!is_array($exclude))
				$exclude = [$exclude];
			
			return $this->getPropertyNames($exclude);
		} 
		else if ($filter) 
		{
			return (is_string($filter) ? [$filter] : $filter);
		}
		
		return null;
	}
	
	
	/**
	 * @param string $field
	 * @return bool
	 */
	public function isModified($field) 
	{
		if (!isset($this->$field))
			throw new PropertyNotFoundException($this, $field);
		
		return isset($this->modified[$field]);
	}
	
	/**
	 * @return bool
	 */
	public function hasModified() 
	{
		return (bool)$this->modified;
	}
	
	/**
	 * @param array|string|bool $filter
	 * @param array|string|bool $exclude
	 * @return array Only the modified property names 
	 */
	public function getModifiedProperties($filter = false, $exclude = false) 
	{
		$filter = $this->getPropertyNamesFilter($filter, $exclude);
		
		$modified = ($filter ? 
			array_intersect_key($this->modified, array_flip($filter)) :
			$this->modified
		);
		
		return array_keys($modified);
	}
	
	/**
	 * @param array|string|bool $filter
	 * @param array|string|bool $exclude
	 * @return array Array were key is property name and value is it's new value.  
	 */
	public function getModified($filter = false, $exclude = false) 
	{
		$modified = $this->getModifiedProperties($filter, $exclude);
		
		if (!$modified) return [];
		
		return $this->toArray($this->getModifiedProperties($filter, $exclude));
	}
	
	/**
	 * @param array|string|bool $filter
	 * @param array|string|bool $exclude
	 */
	public function commit($filter = false, $exclude = false) 
	{
		$filter = $this->getPropertyNamesFilter($filter, $exclude);
		
		if ($filter)
		{
			foreach ($filter as $field)
			{
				unset($this->modified[$field]);
			}
		} 
		else 
		{
			$this->modified = [];
		}
	}
	
	/**
	 * @param array|string|bool $filter
	 * @param array|string|bool $exclude
	 */
	public function rollback($filter = false, $exclude = false)
	{
		$filter = $this->getPropertyNamesFilter($filter, $exclude);
		
		if (!$filter)
		{
			foreach ($this->modified as $key => $value) 
			{
				parent::__set($key, $value);
			}
			
			$this->modified = [];
		}
		else
		{
			foreach ($filter as $field) 
			{
				if (isset($this->modified[$field])) 
				{
					parent::__set($field, $this->modified[$field]);
					unset($this->modified[$field]);
				}
			}
		}
	}
	
	/**
	 * @param array|string $field
	 * @return mixed
	 */
	public function getOriginalValue($field) 
	{
		if (!is_array($field)) 
		{
			return isset($this->modified[$field]) ? 
				$this->modified[$field] : 
				$this->$field;
		}
		
		$result = [];
		
		foreach ($field as $singleField) 
		{
			$result[$singleField] = isset($this->modified[$singleField]) ? 
				$this->modified[$singleField] : 
				$this->$singleField;
		}
		
		return $result;
	}
	
	
	/**
	 * @param string $name
	 * @param mixed $value
	 */
	public function __set($name, $value) 
	{
		if ($this->isRestricted($name))
		{
			parent::__set($name, $value);
			return;
		}
		
		if (!isset($this->modified[$name]))
			$oldValue = $this->$name;
		
		parent::__set($name, $value);
		$newValue = $this->$name;
		
		if (isset($oldValue)) 
		{
			if ($oldValue !== $newValue)
				$this->modified[$name] = $oldValue;
		}
		else if ($newValue === $this->modified[$name])
		{
			unset($this->modified[$name]);
		}
	}
}