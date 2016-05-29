<?php
namespace Objection\Exceptions;


class InvalidValueTypeException extends LiteObjectException 
{
	/**
	 * @param string $expectedType
	 * @param mixed $value
	 */
	public function __construct($expectedType, $value)
	{
		$type = (is_object($value) ? get_class($value) : gettype($value));
		
		parent::__construct("Value of type '$expectedType' expected. Got {$type} instead");
	}
}