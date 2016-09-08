<?php
namespace Objection\Mapper\Loaders;


use Objection\Mapper\Base\Loaders\ILoadHelpersContainer;


class MapperLoadHelpers
{
	/** @var LoadHelpersContainer */
	private $preMapLoaders;
	
	/** @var LoadHelpersContainer */
	private $postMapLoaders;
	
	
	public function __construct() 
	{ 
		$this->preMapLoaders = new LoadHelpersContainer();
		$this->postMapLoaders = new LoadHelpersContainer();
	}
	
	
	/**
	 * @return ILoadHelpersContainer
	 */
	public function pre()
	{
		return $this->preMapLoaders;
	}
	
	/**
	 * @return ILoadHelpersContainer
	 */
	public function post()
	{
		return $this->postMapLoaders;
	}
}