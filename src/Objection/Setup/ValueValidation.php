<?php
namespace Objection\Setup;


use Objection\Enum\VarType;
use Objection\Enum\SetupFields;


class ValueValidation 
{
	use \Objection\TStaticClass;
	
	
	/**
	 * @param array $fieldData
	 * @param string $value
	 * @return bool|float|int|mixed|string
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
					throw new \Exception("Invalid value '$value' for field");
				
				break;
			
			default:
				if (!$value instanceof $fieldData[SetupFields::TYPE]) 
				{
					$type = (is_object($value) ? get_class($fieldData) : gettype($value));
					
					throw new \Exception(
						"Value must be of type {$fieldData[SetupFields::TYPE]}. " . 
						"Got {$type} instead");
				}
				
				break;
		}
		
		return $value;
	}
}