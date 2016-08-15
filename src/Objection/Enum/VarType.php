<?php
namespace Objection\Enum;


class VarType 
{
	use \Objection\TEnum;
	
	
	const INT       = 'int';
	const STRING    = 'string';
	const DOUBLE    = 'double';
	const BOOL      = 'bool';
	const MIXED     = 'mixed';
	const ENUM      = 'enum';
	const ARR       = 'array';
	const DATE_TIME = 'DateTime';
	const CUSTOM    = 'custom';
}