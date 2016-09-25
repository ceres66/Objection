<?php
namespace Objection\Mapper\Values;


use Objection\Mapper\Base\Values\IObjectValuesProcessor;
use Objection\Mapper\Base\Values\IValuesProcessorContainer;


class ValuesProcessorContainer implements IValuesProcessorContainer
{
	/** @var IObjectValuesProcessor[] */
	private $container = [];
	
	
	/**
	 * @param string $className
	 * @return bool
	 */
	public function has($className)
	{
		return isset($this->container[$className]);
	}
	
	/**
	 * @param string $className
	 * @return IObjectValuesProcessor|null
	 */
	public function get($className)
	{
		return isset($this->container[$className]) ?
			$this->container[$className] : 
			null;
	}
	
	/**
	 * @param string $className
	 * @return IObjectValuesProcessor
	 */
	public function getOrCreate($className)
	{
		if (!isset($this->container[$className]))
		{
			$this->container[$className] = new ObjectValuesProcessor();
		}
			
		return $this->container[$className];
	}
}