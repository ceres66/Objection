<?php
namespace Objection\Mapper\Mappers;


use Objection\LiteObject;
use Objection\Mapper\Fields\FirstToLower;
use Objection\Mapper\Fields\CaseInsensitiveMatch;


class JsonFieldsMapper extends CombinedMapper
{
	/** @var JsonFieldsMapper */
	private static $instance = null;
	
	
	/**
	 * @param array|LiteObject $objectFields
	 */
	public function __construct($objectFields)
	{
		if ($objectFields instanceof LiteObject)
			$objectFields = $objectFields->getPropertyNames();
		
		parent::__construct(
			new FirstToLower(), 
			new CaseInsensitiveMatch($objectFields));
	}
	
	
	/**
	 * @param array|LiteObject $objectFields
	 * @return JsonFieldsMapper
	 */
	public static function instance($objectFields)
	{
		if (!self::$instance)
			self::$instance = new JsonFieldsMapper($objectFields);
		
		return self::$instance;
	}
}