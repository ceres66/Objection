<?php
namespace Objection\Internal\Base\Parsing;


use Objection\Internal\Property;
use Objection\Internal\Properties\PropertyList;


abstract class AbstractPropertyParser implements IPropertyParser
{
	/** @var \ReflectionClass */
	private $class;
	
	/** @var PropertyList */
	private $properties;


	/**
	 * @return \ReflectionClass
	 */
	protected function getClass()
	{
		return $this->class;
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
	 * @param \ReflectionClass $class
	 */
	public function setDefinitionClass(\ReflectionClass $class)
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