<?php
namespace Objection\Mapper\Loaders;


use Objection\Mapper\Base\Loaders\ILoadHelper;


class LoadHelpersProcessor
{
	/** @var MapperLoadHelpers */
	private $helpers;
	
	
	/**
	 * @param ILoadHelper[] $helpers
	 * @param array $data
	 * @return array
	 */
	private function process(array $helpers, array $data)
	{
		foreach ($helpers as $helper)
		{
			$keys = array_keys($data);
			$fields = $helper->filterFields($keys, $data);
			
			if ($fields)
			{
				$data = array_intersect_key($data, array_flip($fields));
			}
			
			$data = $helper->mapFields($data);
		}
		
		return $data;
	}
	
	/**
	 * @param ILoadHelper[] $helpers
	 * @param \stdClass|array $data
	 * @return \stdClass|array
	 */
	private function genericProcess(array $helpers, $data)
	{
		$convertToStdClass = false;
		$arrayData = $data;
		
		if (!is_array($data))
		{
			$convertToStdClass = true;
			$arrayData = (array)$data;
		}
		
		$arrayData = $this->process($helpers, $arrayData);
		
		return ($convertToStdClass ? (object)$arrayData : $arrayData);
	}
	
	
	/**
	 * @param MapperLoadHelpers $helpers
	 * @return static
	 */
	public function setLoadersContainer(MapperLoadHelpers $helpers)
	{
		$this->helpers = $helpers;
		return $this;
	}
	
	/**
	 * @param string $className
	 * @param array|\stdClass $data
	 * @return array|\stdClass
	 */
	public function preMapProcess($className, $data)
	{
		$preHelpers = $this->helpers->pre()->get($className);
		
		return ($preHelpers ? 
			$this->genericProcess($preHelpers, $data) : 
			$data);
	}
	
	/**
	 * @param string $className
	 * @param array|\stdClass $data
	 * @return array|\stdClass
	 */
	public function postMapProcess($className, $data)
	{
		$preHelpers = $this->helpers->post()->get($className);
		
		return ($preHelpers ?
			$this->genericProcess($preHelpers, $data) :
			$data);
	}
}