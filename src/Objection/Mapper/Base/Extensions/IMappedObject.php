<?php
namespace Objection\Mapper\Base\Extensions;


interface IMappedObject
{
	/**
	 * @param array $exclude
	 * @return array
	 */
	public function getFields($exclude = []);
	
	/**
	 * @param array $fields
	 */
	public function setFields($fields);
}