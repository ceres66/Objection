<?php
namespace Objection\Mapper\ValuesProcessor;


use Objection\Mapper;
use Objection\Mapper\Base\Values\IValueProcessor;


class JsonMapperValueProcessor implements IValueProcessor
{
	private $className;
	
	/** @var Mapper */
	private $mapper;
	
	
	/**
	 * @param Mapper $mapper
	 * @param string $className
	 */
	public function __construct(Mapper $mapper, $className)
	{
		$this->mapper = $mapper;
		$this->className = $className;
	}
	
	
	/**
	 * @param mixed $rawValue
	 * @return mixed
	 */
	public function toObjectValue($rawValue)
	{
		return $this->mapper->getObject($rawValue, $this->className);
	}
	
	/**
	 * @param mixed $rawValue
	 * @return mixed
	 */
	public function toRawValue($rawValue)
	{
		return $this->mapper->getJson($rawValue);
	}
}