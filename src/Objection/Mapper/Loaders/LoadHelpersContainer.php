<?php
namespace Objection\Mapper\Loaders;


use Objection\Mapper\Base\Loaders\ILoadHelper;
use Objection\Mapper\Base\Loaders\ILoadHelperBuilder;
use Objection\Mapper\Base\Loaders\ILoadHelpersContainer;


class LoadHelpersContainer implements ILoadHelpersContainer
{
	private $loadersPerConcreteClass = [];
	private $loadersPerClassName = [];
	
	
	/**
	 * @param string $concreteClassName
	 */
	private function loadLoadersForConcreteClass($concreteClassName)
	{
		$this->loadersPerConcreteClass[$concreteClassName] = [];
		
		foreach ($this->loadersPerClassName as $className => $loaders)
		{
			if ($concreteClassName == $className || is_subclass_of($concreteClassName, $className, true))
			{
				$this->loadersPerConcreteClass[$concreteClassName] += $loaders;
			}
		}
	}
	
	
	/**
	 * @param string $className
	 * @param ILoadHelper $helper
	 * @return static
	 */
	public function add($className, ILoadHelper $helper)
	{
		if (!isset($this->loadersPerClassName[$className]))
			$this->loadersPerClassName[$className] = [];
		
		$this->loadersPerClassName[$className][] = $helper;
		$this->loadersPerConcreteClass = [];
	}
	
	/**
	 * @param string $className
	 * @return ILoadHelper[]
	 */
	public function get($className)
	{
		if (!isset($this->loadersPerConcreteClass[$className]))
		{
			$this->loadLoadersForConcreteClass($className);
		}	
			
		return $this->loadersPerConcreteClass[$className];
	}
	
	/**
	 * @param string $className
	 * @return ILoadHelperBuilder
	 */
	public function createForClass($className)
	{
		$dynamic = new DynamicLoadHelper();
		$this->add($className, $dynamic);
		return $dynamic;
	}
}