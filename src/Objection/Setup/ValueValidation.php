<?php
namespace Objection\Setup;


use Objection\Exceptions;
use Objection\Enum\VarType;
use Objection\Enum\SetupFields;


class ValueValidation 
{
	use \Objection\TStaticClass;
	
	
	/**
	 * @param array $fieldData
	 * @param mixed $value
	 * @return mixed
	 */
	public static function fixValue($fieldData, $value) 
	{
		if (is_null($value) && isset($fieldData[SetupFields::IS_NULL]))
			return null;
		
		switch ($fieldData[SetupFields::TYPE]) 
		{
			case VarType::MIXED:
				break;
			
			case VarType::BOOL:
				$value = (bool)$value;
				break;
			
			case VarType::INT:
				$value = (int)$value;
				break;
			
			case VarType::STRING:
				$value = (string)$value;
				break;
			
			case VarType::DOUBLE:
				$value = (double)$value;
				break;
			
			case VarType::ARR:
				if (!is_array($value))
					$value = [$value];
				
				break;
			
			case VarType::ENUM:
				if (!isset($fieldData[SetupFields::VALUES_SET][$value]))
					throw new Exceptions\InvalidEnumValueTypeException($fieldData[SetupFields::VALUES_SET], $value);
				
				break;
			
			default:
				if (!$value instanceof $fieldData[SetupFields::TYPE])
					throw new Exceptions\InvalidValueTypeException($fieldData[SetupFields::TYPE], $value);
				
				break;
		}
		
		return $value;
	}
}