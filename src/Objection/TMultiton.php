<?php
namespace Objection;


trait TMultiton 
{
	use TStaticClass;
	
	
	/** @var static[] */
	private static $instances = [];


	/**
	 * @param string|int $key
	 * @return static
	 */
	public static function instance($key) 
	{
		if (!isset(self::$instances[$key])) 
		{
			$instance = new static();
			self::$instances[$key] = $instance;
			self::initialize($instance, $key);
		}

		return self::$instances[$key];
	}
	
	
	/**
	 * @param TMultiton $instance
	 * @param string|int $key
	 */
	protected static function initialize($instance, $key) {}
}