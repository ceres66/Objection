<?php
namespace Objection\Internal\Type;


use Objection\Exceptions\PropertyNotFoundException;
use Objection\Exceptions\ReadOnlyPropertyException;
use Objection\Exceptions\WriteOnlyPropertyException;


abstract class ObjectType
{
	public $setProperties = [];
	public $getProperties = [];
	public $allProperties = [];
	
	
	/** @var \ReflectionProperty[] */
	private $properties = [];
	
	/** @var \ReflectionMethod */
	private $methods = [];
	
	/** @var \ReflectionClass */
	private $class;
	
	
	/**
	 * @param string $name
	 * @return \ReflectionProperty
	 */
	private function getProperty($name)
	{
		if (!isset($this->properties[$name]))
		{
			$property = $this->class->getProperty($name);
			$property->setAccessible(true);
			$this->properties[$name] = $property;
			return $property;
		}
		
		return $this->properties[$name];
	}
	
	/**
	 * @param string $name
	 * @return \ReflectionMethod
	 */
	private function getMethod($name)
	{
		if (!isset($this->properties[$name]))
		{
			$method = $this->class->getMethod($name);
			$method->setAccessible(true);
			$this->methods[$name] = $method;
			return $method;
		}
		
		return $this->methods[$name];
	}

	/**
	 * @param string $name
	 */
	private function throwSetPropertyNotFoundException($name)
	{
		if (!isset($this->getProperties[$name]))
		{
			throw new PropertyNotFoundException($this->class->getName(), $name);
		}
		else 
		{
			throw new ReadOnlyPropertyException($this->class->getName(), $name);
		}
	}

	/**
	 * @param string $name
	 */
	private function throwGetPropertyNotFoundException($name)
	{
		if (!isset($this->setProperties[$name]))
		{
			throw new PropertyNotFoundException($this->class->getName(), $name);
		}
		else 
		{
			throw new WriteOnlyPropertyException($this->class->getName(), $name);
		}
	}
	
	
	/**
	 * @param mixed $instance
	 * @param string $name
	 * @param mixed $value
	 */
	protected function setPropertyValue($instance, $name, $value)
	{
		$property = $this->getProperty($name);
		$property->setValue($instance, $value);
	}

	/**
	 * @param mixed $instance
	 * @param string $name
	 * @return mixed
	 */
	protected function getPropertyValue($instance, $name)
	{
		return $this->getProperty($name)->getValue($instance);
	}
	
	/**
	 * @param mixed $instance
	 * @param string $name
	 * @param array ...$params
	 * @return mixed
	 */
	protected function callMethod($instance, $name, ...$params)
	{
		return $this->getMethod($name)->invokeArgs($instance, $params);
	}
	
	
	/**
	 * @param string|\ReflectionClass $class
	 * @param array $get
	 * @param array $set
	 */
	public function __construct($class, $get, $set)
	{
		if ($class instanceof \ReflectionClass)
		{
			$this->class = $class;
		}
		else
		{
			$this->class = new \ReflectionClass($class);
		}
		
		$this->getProperties = array_combine($get, array_fill(0, count($get), true));
		$this->setProperties = array_combine($set, array_fill(0, count($set), true));
		$this->allProperties = array_merge($this->getProperties, $this->setProperties);
	}
}