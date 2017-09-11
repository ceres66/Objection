<?php
namespace Objection\Mapper\Values;


use Objection\Mapper\Base\Values\IObjectValuesProcessor;
use Objection\Mapper\Base\Values\IValueProcessor;


class ObjectValuesProcessor implements IObjectValuesProcessor
{
	/** @var IValueProcessor[] */
	private $processors;
	
	
	/**
	 * @param string $fieldName
	 * @param IValueProcessor $processor
	 * @return static
	 */
	public function add($fieldName, IValueProcessor $processor)
	{
		$this->processors[$fieldName] = $processor;
		return $this;
	}
	
	/**
	 * @param array $rawDataByObjectFields
	 * @return array
	 */
	public function toObjectValues($rawDataByObjectFields)
	{
		foreach ($this->processors as $field => $processor)
		{
			if (array_key_exists($field, $rawDataByObjectFields))
			{
				$rawDataByObjectFields[$field] = $processor->toObjectValue($rawDataByObjectFields[$field]);
			}
		}
		
		return $rawDataByObjectFields;
	}
	
	/**
	 * @param array $objectDataByObjectFields
	 * @return array
	 */
	public function toRawValues($objectDataByObjectFields)
	{
		foreach ($this->processors as $field => $processor)
		{
			if (array_key_exists($field, $objectDataByObjectFields))
			{
				$objectDataByObjectFields[$field] = $processor->toRawValue($objectDataByObjectFields[$field]);
			}
		}
		
		return $objectDataByObjectFields;
	}
}