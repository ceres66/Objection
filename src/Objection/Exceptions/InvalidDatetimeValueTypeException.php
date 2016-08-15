<?php
namespace Objection\Exceptions;


class InvalidDatetimeValueTypeException extends LiteObjectException 
{
	/**
	 * @param mixed $value
	 */
	public function __construct($value)
	{
		if (is_object($value))
			$type = get_class($value);
		else
			$type = gettype($value);
		
		parent::__construct("Expecting \\DateTime, string, or unix timestamp (int), but got '$type' instead");
	}
}