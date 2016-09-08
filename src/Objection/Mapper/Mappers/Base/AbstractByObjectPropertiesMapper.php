<?php
namespace Objection\Mapper\Mappers\Base;


use Objection\Mapper\Base\Fields\IBidirectionalMapper;
use Objection\Exceptions\LiteObjectException;
use Objection\Setup\Container;


abstract class AbstractByObjectPropertiesMapper implements IBidirectionalMapper
{
	private $fieldsByClassName = [];
	
	
	/**
	 * @param array $fields
	 * @return array
	 */
	private function getFieldsVariations($fields)
	{
		$result = [];
		
		foreach ($fields as $field)
		{
			$variations = $this->getFieldVariations($field);
			
			if (!is_array($variations)) $variations = [$variations];
			
			$objectFieldNameByVariation = array_fill_keys($variations, $field);
			$result += $objectFieldNameByVariation;
		}
		
		return $result;
	}
	
	/**
	 * @param string $className
	 */
	private function loadClassFields($className)
	{
		$fields = Container::instance()->get($className);
		
		if (!$fields)
		{
			new $className;
			$fields = Container::instance()->get($className);
		}
		
		$fields = array_keys($fields);
		
		$this->fieldsByClassName[$className] = $this->getFieldsVariations($fields);
	}
	
	
	/**
	 * @param string $field
	 * @return string[]|string
	 */
	protected abstract function getFieldVariations($field);
	
	
	/**
	 * @param string $objectField
	 * @return string
	 */
	public abstract function mapFromObjectField($objectField);
	
	
	/**
	 * @param string $rowField
	 * @param string $className
	 * @return string
	 */
	public function mapToObjectField($rowField, $className)
	{
		if (!isset($this->fieldsByClassName[$className]))
		{
			$this->loadClassFields($className);
		}
		
		if (!isset($this->fieldsByClassName[$className][$rowField]))
		{
			throw new LiteObjectException("Object field for $rowField is undefined");
		}
		
		return $this->fieldsByClassName[$className][$rowField];
	}
}