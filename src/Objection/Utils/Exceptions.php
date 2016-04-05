<?php
namespace Objection\Utils;


class Exceptions
{
	use \Objection\TStaticClass;
	
	
	/**
	 * @param object $obj
	 * @param string $property
	 * @throws \Exception
	 */
	public static function throwNoProperty($obj, $property) 
	{
		$className = get_class($obj);
		throw new \Exception("No such property '$className->$property'");
	}
	
	/**
	 * @param object $obj
	 * @param string $property
	 * @throws \Exception
	 */
	public static function throwNotSetProperty($obj, $property) 
	{
		$className = get_class($obj);
		throw new \Exception("Trying to modify read only property '$className->$property'");
	}
	
	/**
	 * @param object $obj
	 * @param string $property
	 * @throws \Exception
	 */
	public static function throwNotGetProperty($obj, $property)
	{
		$className = get_class($obj);
		throw new \Exception("Trying to get write only property '$className->$property'");
	}
}