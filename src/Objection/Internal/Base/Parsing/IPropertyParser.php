<?php
namespace Objection\Internal\Base\Parsing;


use Objection\Internal\Properties\PropertyList;


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