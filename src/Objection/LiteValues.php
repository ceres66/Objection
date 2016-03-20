<?php
namespace Oktopost;


use \Objection\Enum\VarType;
use \Objection\Enum\LiteFields;


class LiteValues {
	use \Objection\TStaticClass;
	
	
	/**
	 * @param $fieldData
	 * @param string $value
	 * @return bool|float|int|mixed|string
	 */
	public static function fixValue($fieldData, $value) {
		if (is_null($value) && isset($fieldData[LiteFields::IS_NULL])) {
			return null;
		}
		
		switch ($fieldData[LiteFields::TYPE]) {
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
				if (!is_array($value)) {
					$value = [$value];
				}
				
				break;
			
			case VarType::ENUM:
				if (!isset($fieldData[LiteFields::VALUES_SET][$value])) {
					throw new \Exception("Invalid value '$value' for field");
				}
				
				break;
			
			default:
				throw new \Exception("Invalid property type " . $fieldData[LiteFields::TYPE]);
		}
		
		return $value;
	}
}