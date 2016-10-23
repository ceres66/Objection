<?php
namespace Objection\Exceptions;


use Objection\LiteObject;


class WriteOnlyPropertyException extends LiteObjectException
{
	/**
	 * @param string|LiteObject $object Instance or class name.
	 * @param string $property
	 */
	public function __construct($object, $property)
	{
		if (!is_string($object))
		{
			$object = get_class($object);
		}
		
		parent::__construct("Trying to write to a read-only property '$object->$property'");
	}
}