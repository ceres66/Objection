<?php
namespace Objection\Mapper\Fields;


use Objection\Mapper\Base\Fields\IFieldMapper;


class CaseInsensitiveMatch implements IFieldMapper
{
	private $map = [];
	
	
	/**
	 * @param array $fields
	 */
	public function __construct(array $fields)
	{ 
		foreach ($fields as $field)
		{
			$this->map[strtolower($field)] = $field;
		}
	}
	
	
	/**
	 * @param string $field
	 * @return string
	 */
	public function map($field)
	{
		$field = strtolower($field);
		
		if (!isset($this->map[$field]))
			return false;
		
		return $this->map[$field];
	}
}