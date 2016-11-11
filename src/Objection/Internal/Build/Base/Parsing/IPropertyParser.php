<?php
namespace Objection\Internal\Build\Base\Parsing;


use Objection\Internal\Build\Descriptors\TargetClass;
use Objection\Internal\Build\Descriptors\PropertyList;


interface IPropertyParser
{
	/**
	 * @param TargetClass $class
	 */
	public function setTargetClass(TargetClass $class);

	/**
	 * @param PropertyList $list
	 */
	public function setPropertyList(PropertyList $list);
	
	public function parse();
}