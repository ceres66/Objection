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
	 * @param array $dataToObjectMap Data field name as key, Object field name as value.
	 */
	public function __construct(array $objectToDataMap = [], array $dataToObjectMap = []) 
	{
		if ($objectToDataMap) 
		{
			$this->setObjectToDataMap($objectToDataMap);
		}
		
		if ($dataToObjectMap)
		{
			$this->setDataToObjectMap($dataToObjectMap);
		}
	}
	
	
	/**
	 * @param array $objectToDataMap
	 * @return static
	 */
	public function setObjectToDataMap(array $objectToDataMap)
	{
		$this->objectToData = $objectToDataMap;
		$this->dataToObject = array_merge(array_flip($objectToDataMap), $this->dataToObject);
		return $this;
	}
	
	/**
	 * @param array $dataToObjectMap
	 * @return static
	 */
	public function setDataToObjectMap(array $dataToObjectMap)
	{
		$this->dataToObject = $dataToObjectMap;
		$this->objectToData = array_merge(array_flip($dataToObjectMap), $this->objectToData);
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