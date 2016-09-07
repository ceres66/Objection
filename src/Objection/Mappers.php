<?php
namespace Objection;


use Objection\Mapper\Mappers\HashMapMapper;
use Objection\Mapper\Mappers\JsonFieldsMapper;


class Mappers
{
	use TStaticClass;
	
	
	/**
	 * No changes are made to the fields map.
	 * @return Mapper
	 */
	public static function simple()
	{
		return Mapper::create();
	}
	
	/**
	 * @param array $objectFieldsToDataFields
	 * @param array $dataFieldsToObjectFields
	 * @return Mapper
	 */
	public static function mapped(array $objectFieldsToDataFields, array $dataFieldsToObjectFields = [])
	{
		return Mapper::create(new HashMapMapper($objectFieldsToDataFields, $dataFieldsToObjectFields));
	}
}