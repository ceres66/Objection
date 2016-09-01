<?php
namespace Objection\Mapper\FieldMappers;


use Objection\Mapper\Base\IFieldMapper;
use Objection\Mapper\Base\IBidirectionalFieldMapper;


class BidirectionalCombinedMapper implements IBidirectionalFieldMapper
{
	private $fromObject;
	private $toObject;
	
	
	public function __construct(IFieldMapper $fromObject, IFieldMapper $toObject) 
	{
		$this->fromObject = $fromObject;
		$this->toObject = $toObject;
	}
	
	
	/**
	 * @param string $rowField
	 * @return string
	 */
	public function mapToObjectField($rowField)
	{
		return $this->toObject->map($rowField);
	}
	
	/**
	 * @param string $objectField
	 * @return string
	 */
	public function mapFromObjectField($objectField)
	{
		return $this->fromObject->map($objectField);
	}
}