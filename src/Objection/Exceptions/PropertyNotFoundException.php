<?php
namespace Objection\Exceptions;


use Objection\LiteObject;


class PropertyNotFoundException extends LiteObjectException
{
	/**
	 * @param string|LiteObject $object Instance or class name.
	 * @param int   			$property
	 */
	public function __construct($object, $property)
	{
		if (!is_string($object))
		{
			$object = get_class($object);
		}
		
		parent::__construct("No such property exists '$object->$property'");
	}
}