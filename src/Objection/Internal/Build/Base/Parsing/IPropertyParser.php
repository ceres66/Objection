<?php
namespace Objection\Internal\Build\Base\Parsing;


use Objection\Internal\Build\Descriptors\ObjectifiedClass;
use Objection\Internal\Build\Descriptors\PropertyList;


interface IPropertyParser
{
	/**
	 * @param ObjectifiedClass $class
	 */
	public function setTargetClass(ObjectifiedClass $class);

	/**
	 * @param PropertyList $list
	 */
	public function setPropertyList(PropertyList $list);
	
	public function parse();
}