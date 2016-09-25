<?php
namespace Objection\Mapper\Base\Values;


interface IValuesProcessorContainer
{
	/**
	 * @param string $className
	 * @return bool
	 */
	public function has($className);
	
	/**
	 * @param string $className
	 * @return IObjectValuesProcessor|null
	 */
	public function get($className);
	
	/**
	 * @param string $className
	 * @return IObjectValuesProcessor
	 */
	public function getOrCreate($className);
}