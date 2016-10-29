<?php
namespace Objection\Internal\Build\Annotations;


class PropertyAnnotation
{
	/** @var \ReflectionClass */
	private $sourceClass;
	
	/** @var string */
	private $name;
	
	/** @var string[] */
	private $types;


	/**
	 * @param \ReflectionClass $originalClass
	 * @param string $name
	 * @param string[] $types
	 */
	public function __construct(\ReflectionClass $originalClass, $name, array $types = [])
	{
		$this->sourceClass = $originalClass;
		$this->name = $name;
		$this->types = array_unique($types);
	}


	/**
	 * @return string
	 */
	public function getName()
	{
		return $this->name;	
	}

	/**
	 * @return \ReflectionClass
	 */
	public function getSourceClass()
	{
		return $this->sourceClass;
	}

	/**
	 * @return string[]
	 */
	public function getTypes()
	{
		return $this->types;
	}

	/**
	 * @return bool
	 */
	public function hasTypes()
	{
		return (bool)$this->types;
	}
}