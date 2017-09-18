<?php
namespace Objection;


class ObjectUtils
{
	use TStaticClass;


	/**
	 * @param string $name
	 * @param LiteObject[] $objects
	 * @return mixed[]
	 */
	public static function getProperty(string $name, array $objects): array
	{
		$result = [];
		
		foreach ($objects as $object)
		{
			$result[] = $object->$name;
		}
		
		return $result;
	}
	
	/**
	 * @param string[] $names
	 * @param LiteObject[] $objects
	 * @return mixed[]
	 */
	public static function getProperties(array $names, array $objects): array
	{
		$result = [];
		
		foreach ($objects as $object)
		{
			$result[] = $object->toArray($names);
		}
		
		return $result;
	}
}