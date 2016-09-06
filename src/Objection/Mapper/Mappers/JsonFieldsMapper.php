<?php
namespace Objection\Mapper\Mappers;


use Objection\LiteObject;
use Objection\Mapper\Fields\FirstToLower;
use Objection\Mapper\Fields\CaseInsensitiveMatch;


class JsonFieldsMapper extends CombinedMapper
{
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
}