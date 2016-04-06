<?php
namespace Objection;


use Objection\Enum\SetupFields;
use Objection\Enum\AccessRestriction;
use Objection\Utils\Exceptions;
use Objection\Setup\Container;
use Objection\Setup\ValueValidation;
use Objection\Utils\PrivateFields;


abstract class LiteObject {
	
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
			Exceptions::throwNoProperty($this, $field);
		
		if ($accessRestriction != false && isset($this->data[SetupFields::ACCESS][$accessRestriction]))
			Exceptions::throwNotGetProperty($this, $field);
	}
	
	
	/**
	 * @return array
	 */
	protected abstract function _setup();
	
	
	/**
	 * @param array $values Values to give to a new object.
	 */
	public function __construct(array $values = []) {
		if (Container::instance()->has(get_class($this)))
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
				if (!isset($this->data[SetupFields::ACCESS][AccessRestriction::NO_GET]))
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
		return array_diff(array_keys($this->data), $exclude);
	}
	
	
	/**
	 * @param string $name
	 * @return mixed
	 */
	public function &__get($name) 
	{
		$this->validateFieldAccess($name, AccessRestriction::NO_GET);
		
		// Prevent returning parameter by reference
		if (!isset($this->data[SetupFields::ACCESS][AccessRestriction::NO_SET])) {
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
}