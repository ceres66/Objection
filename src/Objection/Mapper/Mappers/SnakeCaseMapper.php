<?php
namespace Objection\Mapper\Mappers;


use Objection\Mapper\Fields\SnakeCase;
use Objection\Mapper\Mappers\Base\AbstractByObjectPropertiesMapper;


class SnakeCaseMapper extends AbstractByObjectPropertiesMapper
{
	/**
	 * @param string $field
	 * @return string[]|string
	 */
	protected function getFieldVariations($field)
	{
		return strtolower(str_replace('_', '', $field));
	}
	
	
	/**
	 * @param string $objectField
	 * @return string
	 */
	public function mapFromObjectField($objectField)
	{
		static $snakeCase;
		
		if (!$snakeCase)
			$snakeCase = SnakeCase::instance();
		
		return $snakeCase->map($objectField);
	}
	
	public function mapToObjectField($rowField, $className)
	{
		$rowField = str_replace('_', '', $rowField);
		return parent::mapToObjectField($rowField, $className);
	}
}