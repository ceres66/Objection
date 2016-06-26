<?php
namespace Objection;


trait TEnum 
{
	use TStaticClass;
	
	
	/** @var array */
	private static $values = false;
	
	
	private static function loadConsts()
	{
		if (self::$values) return;
		
		foreach ((new \ReflectionClass(__CLASS__))->getConstants() as $value)
		{
			if (is_string($value) || is_int($value))
			{
				self::$values[$value] = $value;
			}
		}
	}
	
	
	/**
	 * @return array
	 */
	public static function getAll() 
	{
		self::loadConsts();
		return array_keys(self::$values);
	}
	
	/**
	 * @param string|int $value
	 * @return bool
	 */
	public static function isExists($value) 
	{
		self::loadConsts();
		return (isset(self::$values[$value]) && self::$values[$value] === $value);
	}
	
	/**
	 * @return int
	 */
	public static function getCount() 
	{
		self::loadConsts();
		return count(self::$values);
	}
}