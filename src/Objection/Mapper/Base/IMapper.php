<?php
namespace Objection\Mapper\Base;


use Objection\LiteObject;


interface IMapper
{
	/**
	 * @param string $json
	 * @param string $className
	 * @return LiteObject
	 */
	public function jsonToObject($json, $className);
	
	/**
	 * @param string $json Expecting "[{object}, {object}...]"
	 * @param string $className
	 * @return LiteObject[]
	 */
	public function jsonToObjects($json, $className);
	
	/**
	 * @param \stdClass $data
	 * @param string $className
	 * @return LiteObject
	 */
	public function stdClassToObject(\stdClass $data, $className);
	
	/**
	 * @param \stdClass $data
	 * @param string $className
	 * @return LiteObject[]
	 */
	public function stdClassToObjects(\stdClass $data, $className);
	
	/**
	 * @param array $data
	 * @param string $className
	 * @return LiteObject
	 */
	public function arrayToObject(array $data, $className);
	
	/**
	 * @param array $data
	 * @param string $className
	 * @return LiteObject[]
	 */
	public function arrayToObjects(array $data, $className);
	
	/**
	 * @param LiteObject $object
	 * @return string
	 */
	public function objectToJson(LiteObject $object);
	
	/**
	 * @param LiteObject[] $objects
	 * @return string In format "[{object}, {object}...]"
	 */
	public function objectsToJson(array $objects);
	
	/**
	 * @param LiteObject $object
	 * @return \stdClass
	 */
	public function objectToStdClass(LiteObject $object);
	
	/**
	 * @param LiteObject[] $objects
	 * @return array Array of \stdClass objects.
	 */
	public function objectsToStdClass(array $objects);
	
	/**
	 * @param LiteObject $object
	 * @return array
	 */
	public function objectToArray(LiteObject $object);
	
	/**
	 * @param LiteObject[] $objects
	 * @return array Array of arrays.
	 */
	public function objectsToArray(array $objects);
}