<?php
namespace Objection;


use \Objection\Enum\VarType;
use \Objection\Enum\LiteFields;


class LiteSetup {
	use \Objection\TSingleton;
	
	
	private static $NULL_INT	= [LiteFields::TYPE => VarType::INT, LiteFields::VALUE => null, LiteFields::IS_NULL => true];
	private static $NULL_STRING	= [LiteFields::TYPE => VarType::STRING, LiteFields::VALUE => null, LiteFields::IS_NULL => true];
	private static $NULL_DOUBLE	= [LiteFields::TYPE => VarType::DOUBLE, LiteFields::VALUE => null, LiteFields::IS_NULL => true];
	private static $NULL_BOOL	= [LiteFields::TYPE => VarType::BOOL, LiteFields::VALUE => null, LiteFields::IS_NULL => true];
	private static $NULL_MIXED	= [LiteFields::TYPE => VarType::MIXED, LiteFields::VALUE => null, LiteFields::IS_NULL => true];
	private static $NULL_ARRAY	= [LiteFields::TYPE => VarType::ARR, LiteFields::VALUE => null, LiteFields::IS_NULL => true];
	
	
	/** @var array[] */
	private $setup = [];
	
	
	/**
	 * @param string $className
	 * @return bool
	 */
	public function has($className) {
		return isset($this->setup[$className]);
	}
	
	/**
	 * @param string $className
	 * @return array
	 */
	public function get($className) {
		return $this->setup[$className];
	}
	
	/**
	 * @param string $className
	 * @param array $setup
	 */
	public function set($className, array $setup) {
		$this->setup[$className] = $setup;
	}
	
	
	public static function createInt($default = 0) {
		return (is_null($default) ?
			self::$NULL_INT :
			[LiteFields::TYPE => VarType::INT, LiteFields::VALUE => $default]
		);
	}
	
	public static function createString($default = '') {
		return (is_null($default) ?
			self::$NULL_STRING :
			[LiteFields::TYPE => VarType::STRING, LiteFields::VALUE => $default]
		);
	}
	
	public static function createDouble($default = 0.0) {
		return (is_null($default) ?
			self::$NULL_DOUBLE :
			[LiteFields::TYPE => VarType::DOUBLE, LiteFields::VALUE => $default]
		);
	}
	
	public static function createBool($default = false) {
		return (is_null($default) ?
			self::$NULL_BOOL :
			[LiteFields::TYPE => VarType::BOOL, LiteFields::VALUE => $default]
		);
	}
	
	public static function createArray($default = []) {
		return (is_null($default) ?
			self::$NULL_ARRAY :
			[LiteFields::TYPE => VarType::ARR, LiteFields::VALUE => is_array($default) ? $default : [$default]]
		);
	}
	
	/**
	 * @param bool $default
	 * @return array
	 */
	public static function createMixed($default = false) {
		return (is_null($default) ?
			self::$NULL_MIXED :
			[LiteFields::TYPE => VarType::MIXED, LiteFields::VALUE => $default]
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
			LiteFields::TYPE			=> VarType::ENUM,
			LiteFields::VALUE			=> $default,
			LiteFields::VALUES_SET		=> $set,
		];
		
		if ($isNull) {
			$data[LiteFields::IS_NULL] = true;
		}
		
		return $data;
	}
}