<?php
namespace Objection\Mapper;


use Objection\LiteObject;
use Objection\Mapper\Base\IBidirectionalFieldMapper;
use Objection\Mapper\Standard\JsonFieldsMapper;


class ObjectMapper
{
	private $className;
	private $fields;
	
	/** @var IBidirectionalFieldMapper|bool $fieldMapper */
	private $mapper;
	
	
	/**
	 * @param string|LiteObject $class
	 * @param IBidirectionalFieldMapper|null $fieldMapper
	 */
	public function __construct($class, IBidirectionalFieldMapper $fieldMapper = null)
	{
		$object = (is_string($class) ? new $class : $class);
		
		$this->fields		= $object->getPropertyNames();
		$this->className	= (is_string($class) ? $class : get_class($class));
		$this->mapper		= (!is_null($fieldMapper) ? $fieldMapper : new JsonFieldsMapper($this->fields ));
	}
	
	
	/**
	 * @param IBidirectionalFieldMapper $mapper
	 */
	public function setMapper(IBidirectionalFieldMapper $mapper = null)
	{
		$this->mapper = $mapper;
	}
	
	
	/**
	 * @param array|\stdClass $data
	 * @return LiteObject
	 */
	public function toObject($data)
	{
		$object = new $this->className;
		
		foreach ($data as $key => $value)
		{
			$field = ($this->mapper ?
				$this->mapper->mapToObjectField($key) : 
				$key);
			
			if ($field)
			{
				$object->$field = $value;
			}
		}
		
		return $object;
	}
	
	/**
	 * @param LiteObject $object
	 * @return array
	 */
	public function fromObject(LiteObject $object)
	{
		$data = [];
		
		foreach ($object->toArray($this->fields) as $field => $value)
		{
			$key = ($this->mapper ? 
				$this->mapper->mapFromObjectField($field) : 
				$field);
			
			$data[$key] = $value;
		}
		
		return $data;
	}
}