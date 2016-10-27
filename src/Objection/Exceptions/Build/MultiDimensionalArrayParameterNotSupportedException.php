<?php
namespace Objection\Exceptions\Build;


use Objection\Exceptions\LiteObjectException;

class MultiDimensionalArrayParameterNotSupportedException extends LiteObjectException
{
	public function __construct($givenTypeName)
	{
		parent::__construct("Only one dimensional arrays are supported. " .
				"Consider using 'array' or '[]' keyword instead of '$givenTypeName'");
	}
}