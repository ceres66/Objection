<?php
namespace Objection\Mapper\Mappers;


use Objection\Mapper\Base\Fields\IBidirectionalMapper;


class DummyMapper implements IBidirectionalMapper
{
	/**
	 * @param string $rowField
	 * @return string
	 */
	public function mapToObjectField($rowField)
	{
		return $rowField;
	}
	
	/**
	 * @param string $objectField
	 * @return string
	 */
	public function mapFromObjectField($objectField)
	{
		return $objectField;
	}
}