<?php
namespace Objection\Exceptions;


class InvalidEnumValueTypeException extends LiteObjectException 
{
	/**
	 * @param array $enumValues
	 * @param mixed $value
	 */
	public function __construct($enumValues, $value)
	{
		$expectedValues = implode(', ', $enumValues);
		
		parent::__construct("One of '$expectedValues' expected. Got '$value' instead");
	}
}