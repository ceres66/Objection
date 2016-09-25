<?php
namespace Objection\Mapper\Base\Values;


interface IObjectValuesProcessor
{
	/**
	 * @param string $fieldName
	 * @param IValueProcessor $processor
	 * @return static
	 */
	public function add($fieldName, IValueProcessor $processor);
	
	/**
	 * @param array $rawDataByObjectFields
	 * @return array
	 */
	public function toObjectValues($rawDataByObjectFields);
	
	/**
	 * @param array $objectDataByObjectFields
	 * @return array
	 */
	public function toRawValues($objectDataByObjectFields);
}