<?php
namespace Objection;


use Objection\Enum\SetupFields;
use Objection\Enum\AccessRestriction;
use Objection\Utils\Exceptions;
use Objection\Setup\Container;
use Objection\Setup\ValueValidation;


abstract class LiteObject {
	
	/** @var array */
	private $data;
	
	
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
	 * @return array
	 */
	protected abstract function _setup();
	
	
	/**
	 * @param array $values Values to give to a new object.
	 */
	public function __construct(array $values = []) {
		if (!Container::instance()->has(get_class($this))) 
		{
			$this->data = $this->_setup();
			Container::instance()->set(get_class($this), $this->data);
		} 
		else 
		{
			$this->data = Container::instance()->get(get_class($this));
		}
		
		if ($values) 
		{
			$this->fromArray($values);
		}
	}
	
	
	/**
	 * @param array $map
	 * @return static
	 */
	public function fromArray(array $map) {
		foreach ($map as $property => $value) 
		{
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
				$result[$property] = $this->$property;
			}
		} 
		else 
		{
			foreach ($this->data as $property => $data) 
			{
				if (!isset($this->data[SetupFields::ACCESS][AccessRestriction::NO_GET]))
					$result[$property] = $data[SetupFields::VALUE];
			}
		}
		
		return $result;
	}
	
	/**
	 * @param array $exclude
	 * @return array
	 */
	public function getPropertyNames(array $exclude = [])
	{
		return array_diff(array_keys($this->data), $exclude);
	}
	
	
	/**
	 * @param string $name
	 * @return mixed
	 */
	public function &__get($name) 
	{
		if (!isset($this->data[$name]))
			Exceptions::throwNoProperty($this, $name);
		
		if (isset($this->data[SetupFields::ACCESS][AccessRestriction::NO_GET]))
			Exceptions::throwNotGetProperty($this, $name);
		
		return $this->data[$name][SetupFields::VALUE];
	}
	
	/**
	 * @param string $name
	 * @param mixed $value
	 */
	public function __set($name, $value) 
	{
		if (!isset($this->data[$name]))
			Exceptions::throwNoProperty($this, $name);
		
		if (isset($this->data[SetupFields::ACCESS][AccessRestriction::NO_SET])) 
			Exceptions::throwNotSetProperty($this, $name);
		
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
}