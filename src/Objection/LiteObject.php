<?php
namespace Objection;


use Objection\Exceptions;
use Objection\Enum\SetupFields;
use Objection\Enum\AccessRestriction;
use Objection\Utils\PrivateFields;
use Objection\Setup\Container;
use Objection\Setup\ValueValidation;


abstract class LiteObject
{
	/** @var array */
	private $data;
	
	
	/** @var static */
	protected $_p;
	
	
	/**
	 * @param string $field
	 * @param mixed $value
	 */
	private function invokeOnSet($field, $value) 
	{
		$field = ucfirst($field);
		$method = [$this, "onSet$field"];
		
		if (is_callable($method)) 
		{
			$method($value);
		}
	}
	
	/**
	 * @param string $field
	 * @param int|bool $accessRestriction
	 * @throws \Exception
	 */
	private function validateFieldAccess($field, $accessRestriction = false)
	{
		if (!isset($this->data[$field]))
			throw new Exceptions\PropertyNotFoundException($this, $field);
		
		if ($accessRestriction !== false && isset($this->data[$field][SetupFields::ACCESS][$accessRestriction]))
		{
			if ($accessRestriction == AccessRestriction::NO_GET)
			{
				throw new Exceptions\WriteOnlyPropertyException($this, $field);
			}
			else
			{
				throw new Exceptions\ReadOnlyPropertyException($this, $field);
			}
		}
	}
	
	
	/**
	 * @return array
	 */
	protected abstract function _setup();
	
	
	/**
	 * @param array $values Values to give to a new object.
	 */
	public function __construct(array $values = []) 
	{
		if (!Container::instance()->has(get_class($this)))
			Container::instance()->set(get_class($this), $this->_setup());
		
		$this->data = Container::instance()->get(get_class($this));
		$this->_p = new PrivateFields($this->data, $this);
		
		foreach ($values as $property => $value) 
		{
			$this->_p->$property = $value;
		}
	}
	
	
	/**
	 * @param array $map
	 * @param bool $ignoreGetOnly Don't thrown an exception if Get only property found in the array
	 * @return static
	 */
	public function fromArray(array $map, $ignoreGetOnly = true)
	{
		foreach ($map as $property => $value) 
		{
			if ($ignoreGetOnly && isset($this->data[$property][SetupFields::ACCESS][AccessRestriction::NO_SET]))
				continue;
			
			$this->$property = $value;
		}
		
		return $this;
	}
	
	/**
	 * @param array $filter
	 * @param array $exclude If set, $filter is ignored
	 * @return array
	 */
	public function toArray(array $filter = [], array $exclude = [])
	{
		$result = [];
		
		if ($exclude) $filter = $this->getPropertyNames($exclude);
		
		if ($filter) 
		{
			foreach ($filter as $property) 
			{
				if (!isset($this->data[$property][SetupFields::ACCESS][AccessRestriction::NO_GET]))
					$result[$property] = $this->$property;
			}
		} 
		else 
		{
			foreach ($this->data as $property => $data) 
			{
				if (!isset($this->data[$property][SetupFields::ACCESS][AccessRestriction::NO_GET]))
					$result[$property] = $data[SetupFields::VALUE];
			}
		}
		
		return $result;
	}
	
	/**
	 * @param string $field
	 * @return bool
	 */
	public function isRestricted($field)
	{
		$this->validateFieldAccess($field);
		return isset($this->data[$field][SetupFields::ACCESS]);
	}
	
	/**
	 * @param array $exclude
	 * @return array
	 */
	public function getPropertyNames(array $exclude = [])
	{
		if (!$exclude) return array_keys($this->data);
		
		return array_values(array_diff(array_keys($this->data), $exclude));
	}
	
	
	/**
	 * @param string $name
	 * @return mixed
	 */
	public function &__get($name) 
	{
		$this->validateFieldAccess($name, AccessRestriction::NO_GET);
		
		// Prevent returning parameter by reference
		if (isset($this->data[$name][SetupFields::ACCESS][AccessRestriction::NO_SET]))
		{
			$data = $this->data[$name][SetupFields::VALUE];
			return $data;
		}
		
		return $this->data[$name][SetupFields::VALUE];
	}
	
	/**
	 * @param string $name
	 * @param mixed $value
	 */
	public function __set($name, $value) 
	{
		$this->validateFieldAccess($name, AccessRestriction::NO_SET);
		
		$value = ValueValidation::fixValue($this->data[$name], $value);
		$this->data[$name][SetupFields::VALUE] = $value;
		
		$this->invokeOnSet($name, $value);
	}
	
	/**
	 * @param string $name
	 * @return bool
	 */
	public function __isset($name) 
	{
		return isset($this->data[$name]);
	}
	
	
	/**
	 * @param LiteObject[] $objects
	 * @param array $filter
	 * @param array $exclude If set, $filter is ignored
	 * @return array
	 */
	public static function allToArray(array $objects, array $filter = [], array $exclude = [])
	{
		array_walk($objects,
			function(&$object)
				use ($filter, $exclude)
			{ 
				/** @var LiteObject $object */
				$object = $object->toArray($filter, $exclude);
			});
		
		return $objects;
	}
	
	/**
	 * Need to be called using the class name that is expected.
	 * @param array $mapsSet
	 * @return LiteObject[]
	 */
	public static function allFromArray(array $mapsSet)
	{
		array_walk($mapsSet,
			function(&$map)
			{
				$map = (new static())->fromArray($map);
			});
		
		return $mapsSet;
	}
}