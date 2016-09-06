<?php
namespace Objection\Mapper\Base\Extensions;


interface IMappedObject
{
	/**
	 * @return array
	 */
	public function getObjectData();
	
	/**
	 * @param array $fields
	 */
	public function setObjectData($fields);
}