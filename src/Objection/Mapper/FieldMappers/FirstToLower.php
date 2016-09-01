<?php
namespace Objection\Mapper\FieldMappers;


use Objection\Mapper\Base\IFieldMapper;


class FirstToLower implements IFieldMapper
{
	/**
	 * @param string $field
	 * @return string
	 */
	public function map($field)
	{
		if (!$field || ctype_lower($field[0])) return $field;
		
		$length = strlen($field);
		$field[0] = strtolower($field[0]);
		
		for ($i = 0; $i < $length; $i++)
		{
			if ($i < $length - 1 && ctype_lower($field[$i + 1]))
				break;
			
			$field[$i] = strtolower($field[$i]);
		}
		
		return $field;
	}
}