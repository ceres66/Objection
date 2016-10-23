<?php
namespace Objection\Exceptions;


use Objection\LiteObject;


class ReadOnlyPropertyException extends LiteObjectException
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
		
		parent::__construct("Trying to read, write-only property '$object->$property'");
	}
}