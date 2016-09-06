<?php
namespace Objection\Mapper\Base;


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
	 * @param string $className
	 * @return bool
	 */
	public function has($className);
	
	/**
	 * @param string $className
	 * @return IBidirectionalMapper|null
	 */
	public function get($className);
	
	/**
	 * @param string $className
	 * @return IBidirectionalMapper|null
	 */
	public function getOrDefault($className);
	
	/**
	 * @param string $className
	 * @param IBidirectionalMapper $mapper
	 * @return static
	 */
	public function set($className, IBidirectionalMapper $mapper);
}