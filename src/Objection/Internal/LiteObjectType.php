<?php
namespace Objection\Internal;


class LiteObjectType
{
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
	 */
	public function __construct($class)
	{
		if ($class instanceof \ReflectionClass)
		{
			$this->class = $class;
		}
		else
		{
			$this->class = new \ReflectionClass($class);
		}
	}
}