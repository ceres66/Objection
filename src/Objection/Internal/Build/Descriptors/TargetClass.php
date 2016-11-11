<?php
namespace Objection\Internal\Build\Descriptors;


class TargetClass
{
	/** @var \ReflectionClass */
	private $class;
	
	/** @var SourceFile */
	private $sourceFile;
	
	
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

	/**
	 * @return SourceFile
	 */
	public function getSourceFile()
	{
		if (!$this->sourceFile)
			$this->sourceFile = new SourceFile($this->class->getFileName());
		
		return $this->sourceFile;
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