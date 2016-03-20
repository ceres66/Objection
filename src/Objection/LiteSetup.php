<?php
namespace Objection;


use \Objection\Enum\VarType;
use \Objection\Enum\SetupFields;


class LiteSetup {
	use \Objection\TSingleton;
	
	
	private static $NULL_INT	= [SetupFields::TYPE => VarType::INT, SetupFields::VALUE => null, SetupFields::IS_NULL => true];
	private static $NULL_STRING	= [SetupFields::TYPE => VarType::STRING, SetupFields::VALUE => null, SetupFields::IS_NULL => true];
	private static $NULL_DOUBLE	= [SetupFields::TYPE => VarType::DOUBLE, SetupFields::VALUE => null, SetupFields::IS_NULL => true];
	private static $NULL_BOOL	= [SetupFields::TYPE => VarType::BOOL, SetupFields::VALUE => null, SetupFields::IS_NULL => true];
	private static $NULL_MIXED	= [SetupFields::TYPE => VarType::MIXED, SetupFields::VALUE => null, SetupFields::IS_NULL => true];
	private static $NULL_ARRAY	= [SetupFields::TYPE => VarType::ARR, SetupFields::VALUE => null, SetupFields::IS_NULL => true];
	
	
	public static function createInt($default = 0) {
		return (is_null($default) ?
			self::$NULL_INT :
			[SetupFields::TYPE => VarType::INT, SetupFields::VALUE => $default]
		);
	}
	
	public static function createString($default = '') {
		return (is_null($default) ?
			self::$NULL_STRING :
			[SetupFields::TYPE => VarType::STRING, SetupFields::VALUE => $default]
		);
	}
	
	public static function createDouble($default = 0.0) {
		return (is_null($default) ?
			self::$NULL_DOUBLE :
			[SetupFields::TYPE => VarType::DOUBLE, SetupFields::VALUE => $default]
		);
	}
	
	public static function createBool($default = false) {
		return (is_null($default) ?
			self::$NULL_BOOL :
			[SetupFields::TYPE => VarType::BOOL, SetupFields::VALUE => $default]
		);
	}
	
	public static function createArray($default = []) {
		return (is_null($default) ?
			self::$NULL_ARRAY :
			[SetupFields::TYPE => VarType::ARR, SetupFields::VALUE => is_array($default) ? $default : [$default]]
		);
	}
	
	/**
	 * @param bool $default
	 * @return array
	 */
	public static function createMixed($default = false) {
		return (is_null($default) ?
			self::$NULL_MIXED :
			[SetupFields::TYPE => VarType::MIXED, SetupFields::VALUE => $default]
		);
	}
	
	/**
	 * @param array $set All possible values for this field.
	 * @param string|bool $default
	 * @param bool $isNull
	 * @return array
	 */
	public static function createEnum(array $set, $default = false, $isNull = false) {
		if (!$default) {
			$default = $set[0];
		}
		
		$set = array_flip($set);
		
		$data = [
			SetupFields::TYPE			=> VarType::ENUM,
			SetupFields::VALUE			=> $default,
			SetupFields::VALUES_SET		=> $set,
		];
		
		if ($isNull) {
			$data[SetupFields::IS_NULL] = true;
		}
		
		return $data;
	}
}