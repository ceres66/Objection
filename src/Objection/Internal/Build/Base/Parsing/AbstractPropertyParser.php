<?php
namespace Objection\Internal\Build\Base\Parsing;


use Objection\Internal\Property;
use Objection\Internal\Build\Descriptors\PropertyList;
use Objection\Internal\Build\Descriptors\ObjectifiedClass;


abstract class AbstractPropertyParser implements IPropertyParser
{
	/** @var ObjectifiedClass */
	private $class;
	
	/** @var PropertyList */
	private $properties;


	/**
	 * @return ObjectifiedClass
	 */
	protected function getClass()
	{
		return $this->class;
	}

	/**
	 * @return \ReflectionClass
	 */
	protected function getReflectionClass()
	{
		return $this->class->getReflection();
	}

	/**
	 * @return PropertyList
	 */
	protected function getPropertiesList()
	{
		return $this->properties;
	}
	
	/**
	 * @param string $name
	 * @return Property
	 */
	protected function getOrCreateProperty($name)
	{
		return $this->properties->getOrCreate($name); 
	}
	

	/**
	 * @param ObjectifiedClass $class
	 */
	public function setTargetClass(ObjectifiedClass $class)
	{
		$this->class = $class;
	}

	/**
	 * @param PropertyList $list
	 */
	public function setPropertyList(PropertyList $list)
	{
		$this->properties = $list;
	}
}