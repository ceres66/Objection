<?php
namespace Objection;


abstract class StateObject extends LiteObject {
	
	private $modified = [];
	
	
	/**
	 * @param array $values
	 */
	public function __construct(array $values = []) {
		parent::__construct();
		
		foreach ($values as $property => $value) {
			parent::__set($property, $value);
		}
	}
	
	
	/**
	 * @return bool
	 */
	public function isModified($field) {
		return isset($this->modified[$field]);
	}
	
	/**
	 * @return bool
	 */
	public function hasModified() {
		return (bool)$this->modified;
	}
	
	/**
	 * @param array|string|bool $filter
	 * @param array|string|bool $exclude
	 * @return array
	 */
	public function getModified($filter = false, $exclude = false) {
		$filter = $this->getPropertyNamesFilter($filter, $exclude);
		
		if ($filter) {
			return array_intersect_key($this->modified, array_flip($filter));
		} else {
			return $this->modified;
		}
	}
	
	/**
	 * @param array|string|bool $filter
	 * @param array|string|bool $exclude
	 */
	public function commit($filter = false, $exclude = false) {
		$filter = $this->getPropertyNamesFilter($filter, $exclude);
		
		if ($filter) {
			if (is_string($filter)) {
				unset($this->modified[$filter]);
			} else {
				foreach ($filter as $field) {
					unset($this->modified[$field]);
				}
			}
		} else {
			$this->modified = [];
		}
	}
	
	/**
	 * @param array|string|bool $filter
	 * @param array|string|bool $exclude
	 */
	public function rollback($filter = false, $exclude = false) {
		$filter = $this->getPropertyNamesFilter($filter, $exclude);
		
		if ($filter) {
			if (is_string($filter)) {
				if (isset($this->modified[$filter])) {
					$this->$filter = $this->modified[$filter];
					unset($this->modified[$filter]);
				}
			} else {
				foreach ($filter as $field) {
					if (isset($this->modified[$field])) {
						$this->$field = $this->modified[$field];
						unset($this->modified[$field]);
					}
				}
			}
		} else {
			foreach ($this->modified as $key => $value) {
				$this->$key = $value;
			}
			
			$this->modified = [];
		}
	}
	
	/**
	 * @param array|string $field
	 * @return mixed
	 */
	public function getOriginalValue($field) {
		if (!is_array($field)) {
			return isset($this->modified[$field]) ? 
				$this->modified[$field] : 
				$this->$field;
		}
		
		$result = [];
		
		foreach ($field as $singleField) {
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
	public function __set($name, $value) {
		if (!isset($this->modified[$name])) {
			$oldValue = $this->$name;
		}
		
		parent::__set($name, $value);
		$newValue = $this->$name;
		
		if (isset($oldValue)) {
			if ($oldValue !== $newValue) {
				$this->modified[$name] = $oldValue;
			}
		} else {
			if ($newValue === $this->modified[$name]) {
				unset($this->modified[$name]);
			}
		}
	}
	
	
	/**
	 * @param array|string|bool $filter
	 * @param array|string|bool $exclude
	 * @return array|null
	 */
	private function getPropertyNamesFilter($filter, $exclude) {
		if ($exclude) {
			if (!is_array($exclude)) {
				$exclude = [$exclude];
			}
			
			return $this->getPropertyNames($exclude);
		} else if ($filter) {
			return $filter;
		}
		
		return null;
	}
}