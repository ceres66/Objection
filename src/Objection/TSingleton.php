<?php
namespace Objection;


trait TSingleton 
{
	use TStaticClass;
	
	
	/**
	 * @var static
	 */
	private static $instance = null;


	/**
	 * @return static
	 */
	public static function instance() 
	{
		if (is_null(self::$instance)) 
		{
			self::$instance = new static();
			self::initialize(self::$instance);
		}

		return self::$instance;
	}
	
	
	/**
	 * @param static $instance
	 */
	protected static function initialize($instance) {}
}