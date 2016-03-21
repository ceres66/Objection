<?php
namespace Objection\Enum;


class VarType 
{
	use \Objection\TConstsClass;
	
	
	const INT		= 'int';
	const STRING	= 'string';
	const DOUBLE	= 'double';
	const BOOL		= 'bool';
	const MIXED		= 'mixed';
	const ENUM		= 'enum';
	const ARR		= 'array';
}