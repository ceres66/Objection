<?php
namespace Objection\Internal\Build\Base\Parsing;


use Objection\Internal\Build\Properties\PropertyList;


interface IPropertyParser
{
	/**
	 * @param \ReflectionClass $class
	 */
	public function setDefinitionClass(\ReflectionClass $class);

	/**
	 * @param PropertyList $list
	 */
	public function setPropertyList(PropertyList $list);
	
	public function parse();
}