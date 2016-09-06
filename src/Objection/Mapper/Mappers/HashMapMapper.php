<?php
namespace Objection\Mapper\Mappers;


use Objection\Mapper\Base\Fields\IBidirectionalMapper;
use Objection\Exceptions\LiteObjectException;


class HashMapMapper implements IBidirectionalMapper
{
	private $objectToData = [];
	private $dataToObject = [];
	
	
	/**
	 * @param array $objectToDataMap Object field name as key, Data field name as value.
	 */
	public function __construct(array $objectToDataMap = []) 
	{
		if ($objectToDataMap) 
		{
			$this->setObjectToDataMap($objectToDataMap);
		}
	}
	
	
	/**
	 * @param array $objectToDataMap
	 * @return static
	 */
	public function setObjectToDataMap(array $objectToDataMap)
	{
		$this->objectToData = $objectToDataMap;
		$this->dataToObject = array_flip($objectToDataMap);
		return $this;
	}
	
	/**
	 * @param array $dataToObjectMap
	 * @return static
	 */
	public function setDataToObjectMap(array $dataToObjectMap)
	{
		$this->dataToObject = $dataToObjectMap;
		$this->objectToData = array_flip($dataToObjectMap);
		return $this;
	}
	
	
	/**
	 * @param string $rowField
	 * @return string
	 */
	public function mapToObjectField($rowField)
	{
		if (!isset($this->dataToObject[$rowField]))
			throw new LiteObjectException("Data field $rowField is undefined");
		
		return$this->dataToObject[$rowField];
	}
	
	/**
	 * @param string $objectField
	 * @return string
	 */
	public function mapFromObjectField($objectField)
	{
		if (!isset($this->objectToData[$objectField]))
			throw new LiteObjectException("Object field $objectField is undefined");
		
		return $this->objectToData[$objectField];
	}
}