<?php
namespace Objection\Mapper\Base\Loaders;


interface ILoadHelpersContainer
{
	/**
	 * @param string $className
	 * @param ILoadHelper $helper
	 * @return static
	 */
	public function add($className, ILoadHelper $helper);
	
	/**
	 * @param string $className
	 * @return ILoadHelper[]
	 */
	public function get($className);
	
	/**
	 * @param string $className
	 * @return ILoadHelperBuilder
	 */
	public function createForClass($className);
}