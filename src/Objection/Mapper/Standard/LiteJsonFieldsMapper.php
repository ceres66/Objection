<?php
namespace Objection\Mapper\Standard;


use Objection\LiteObject;
use Objection\Mapper\FieldMappers\FirstToLower;
use Objection\Mapper\FieldMappers\CaseInsensitiveMatch;
use Objection\Mapper\FieldMappers\BidirectionalCombinedMapper;


class LiteJsonFieldsMapper extends BidirectionalCombinedMapper
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