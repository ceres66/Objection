<?php
namespace Objection\Mapper\Utils;


use Objection\LiteObject;
use Objection\Mapper\Base\IMapper;


abstract class AbstractMapper implements IMapper
{
	/**
	 * @param string $json
	 * @param string $className
	 * @return LiteObject
	 */
	public function jsonToObject($json, $className)
	{
		return $this->stdClassToObject(json_decode($json), $className);
	}
	
	/**
	 * @param string $json
	 * @param string $className
	 * @return LiteObject
	 */
	public function jsonToObjects($json, $className)
	{
		return $this->stdClassToObjects(json_decode($json), $className);
	}
	
	/**
	 * @param array $objects
	 * @return string
	 */
	public function objectsToJson(array $objects)
	{
		return json_encode($this->objectsToStdClass($objects));
	}
	
	/**
	 * @param LiteObject $object
	 * @return string
	 */
	public function objectToJson(LiteObject $object)
	{
		return json_encode($this->objectToStdClass($object));
	}
}