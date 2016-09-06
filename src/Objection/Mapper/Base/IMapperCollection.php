<?php
namespace Objection\Mapper\Base;


use Objection\LiteObject;
use Objection\Mapper\Base\Fields\IBidirectionalMapper;


interface IMapperCollection
{
	/**
	 * @return IBidirectionalMapper
	 */
	public function getDefault();
	
	/**
	 * @param IBidirectionalMapper $mapper
	 * @return static
	 */
	public function setDefault(IBidirectionalMapper $mapper);
	
	/**
	 * @param string|LiteObject $className
	 * @return bool
	 */
	public function has($className);
	
	/**
	 * @param string|LiteObject $className
	 * @return IBidirectionalMapper|null
	 */
	public function get($className);
	
	/**
	 * @param string|LiteObject $className
	 * @return IBidirectionalMapper
	 */
	public function getOrDefault($className);
	
	/**
	 * @param string|LiteObject $className
	 * @param IBidirectionalMapper $mapper
	 * @return static
	 */
	public function set($className, IBidirectionalMapper $mapper);
}