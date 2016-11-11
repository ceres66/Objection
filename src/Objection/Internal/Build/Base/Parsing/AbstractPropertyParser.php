<?php
namespace Objection\Internal\Build\Base\Parsing;


use Objection\Internal\Property;
use Objection\Internal\Build\DataTypes\TypeFactory;
use Objection\Internal\Build\Descriptors\TargetClass;
use Objection\Internal\Build\Descriptors\PropertyList;


abstract class AbstractPropertyParser implements IPropertyParser
{
	/** @var TargetClass */
	private $class;
	
	/** @var PropertyList */
	private $properties;


	/**
	 * @return TargetClass
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
	 * @return TypeFactory
	 */
	protected function getTypeFactory()
	{
		return $this->class->getSourceFile()->getTypeFactory();
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
	 * @param TargetClass $class
	 */
	public function setTargetClass(TargetClass $class)
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