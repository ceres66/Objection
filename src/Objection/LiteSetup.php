<?php
namespace Objection;


use Objection\Enum\VarType;
use Objection\Enum\SetupFields;


class LiteSetup 
{
	use \Objection\TSingleton;
	
	
	/**
	 * @param string $type
	 * @param mixed $default
	 * @param bool $isNull
	 * @param int|bool $access
	 * @return array
	 */
	public static function create($type, $default, $isNull = false, $access = false)
	{
		$data = [
			SetupFields::TYPE => $type, 
			SetupFields::VALUE => $default
		];
		
		if (is_null($default) || $isNull)
			$data[SetupFields::IS_NULL] = true;
		
		if ($access !== false) 
			$data[SetupFields::ACCESS] = [$access => true];
		
		return $data;
	}
	
	public static function createInt($default = 0) 
	{
		return self::create(VarType::INT, $default);
	}
	
	public static function createString($default = '')
	{
		return self::create(VarType::STRING, $default);
	}
	
	public static function createDouble($default = 0.0)
	{
		return self::create(VarType::DOUBLE, $default);
	}
	
	public static function createBool($default = false) 
	{
		return self::create(VarType::BOOL, $default);
	}
	
	public static function createArray($default = [])
	{
		if (!is_null($default) && !is_array($default)) $default = [$default];
		
		return self::create(VarType::ARR, $default);
	}
	
	public static function createMixed($default = false)
	{
		return self::create(VarType::MIXED, $default);
	}
	
	/**
	 * @param array $set All possible values for this field.
	 * @param string|null|bool $default
	 * @param bool $isNull
	 * @return array
	 */
	public static function createEnum(array $set, $default = false, $isNull = false)
	{
		if ($default === false) $default = $set[0];
		
		$set = array_flip($set);
		
		$data = [
			SetupFields::TYPE			=> VarType::ENUM,
			SetupFields::VALUE			=> $default,
			SetupFields::VALUES_SET		=> $set,
		];
		
		if (is_null($default) || $isNull) 
		{
			$data[SetupFields::IS_NULL] = true;
		}
		
		return $data;
	}
}