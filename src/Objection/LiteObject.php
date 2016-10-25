<?php
namespace Objection;


use Objection\Exceptions;
use Objection\Utils\ArrayParser;
use Objection\Internal\Type\ObjectType;
use Objection\Internal\Type\TypesContainer;


abstract class LiteObject
{
	/** @var ObjectType */
	private $type;
	
	
	public function __construct() 
	{
		$this->type = TypesContainer::instance()->getType(get_class($this));
	}
	
	
	/**
	 * @param array|\stdClass $source
	 * @param bool $ignoreGetOnly Don't thrown an exception if Get only property found in the array
	 * @return static
	 */
	public function fromArray($source, $ignoreGetOnly = true)
	{
		ArrayParser::fromArray($this, $source, $ignoreGetOnly);
		return $this;
	}
	
	/**
	 * @param array $filter
	 * @param array $exclude If set, $filter is ignored
	 * @return array
	 */
	public function toArray(array $filter = [], array $exclude = [])
	{
		return ArrayParser::toArray($this, $filter, $exclude);
	}
	
	/**
	 * @param array $exclude
	 * @return array
	 */
	public function getPropertyNames(array $exclude = [])
	{
		if (!$exclude) return array_keys($this->type->allProperties);
		
		return array_values(array_diff(array_keys($this->type->allProperties), $exclude));
	}
	
	
	/**
	 * @param string $name
	 * @return mixed
	 */
	public function __get($name)
	{
		if (!isset($this->type->getProperties[$name]))
			throw new \Exception('TODO:');
		
		$name = "get_prop_$name";
		$this->type->$name($this);
	}
	
	/**
	 * @param string $name
	 * @param mixed $value
	 */
	public function __set($name, $value) 
	{
		if (!isset($this->type->setProperties[$name]))
			throw new \Exception('TODO:');
		
		$name = "set_prop_$name";
		$this->type->$name($this, $value);
	}
	
	/**
	 * @param string $name
	 * @return bool
	 */
	public function __isset($name) 
	{
		return isset($this->type->allProperties[$name]);
	}
	
	
	/**
	 * @param LiteObject[] $objects
	 * @param array $filter
	 * @param array $exclude If set, $filter is ignored
	 * @return array
	 */
	public static function allToArray(array $objects, array $filter = [], array $exclude = [])
	{
		return ArrayParser::allToArray($objects, $filter, $exclude);
	}
	
	/**
	 * @param array $mapsSet
	 * @return LiteObject[]
	 */
	public static function allFromArray(array $mapsSet)
	{
		return ArrayParser::allFromArray(static::class, $mapsSet);
	}
}