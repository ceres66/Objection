<?php
namespace Objection\Internal\Build;


class ObjectifiedClass
{
	/** @var \ReflectionClass */
	private $class;
	
	
	/**
	 * @param string|\ReflectionClass $class
	 */
	public function __construct($class)
	{
		if (is_string($class))
		{
			$this->class = new \ReflectionClass($class);
		}
		else
		{
			$this->class = $class;
		}
	}
	
	
	/**
	 * @return \ReflectionProperty[]
	 */
	public function getProperties()
	{
		$properties = [];
		
		foreach ($this->class->getProperties() as $property)
		{
			if ($property->getDeclaringClass() == $this->class)
			{
				$properties[] = $property;
			}
		}
		
		return $properties;
	}
	
	/**
	 * @param string|bool $nameFilter
	 * @return \ReflectionMethod[]
	 */
	public function getMethods($nameFilter = false)
	{
		$methods = [];
		
		foreach ($this->class->getMethods() as $method)
		{
			if ($method->getDeclaringClass() != $this->class)
			{
				continue;
			}
			
			if ($nameFilter && strpos($method->getName(), $nameFilter) !== 0)
			{
				continue;
			}
			
			$methods[] = $method;
		}
		
		return $methods;
	}
	
	public function getSourceFile()
	{
		return $this->class->getFileName();
	}
	
	/**
	 * @return string
	 */
	public function getDocBlock()
	{
		return $this->class->getDocComment();
	}
	
	/**
	 * @return string
	 */
	public function getFullName()
	{
		return $this->class->getName();
	}
	
	/**
	 * @return \ReflectionClass
	 */
	public function getReflection()
	{
		return $this->class;
	}
}