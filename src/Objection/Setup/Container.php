<?php
namespace Objection\Setup;


class Container {
	use \Objection\TSingleton;
	
	
	/** @var array[] */
	private $setup = [];
	
	
	/**
	 * @param string $className
	 * @return bool
	 */
	public function has($className) {
		return isset($this->setup[$className]);
	}
	
	/**
	 * @param string $className
	 * @param array $setup
	 */
	public function set($className, array $setup) {
		if (isset($this->setup[$className])) {
			throw new \Exception("The class [$className] is already defined!");
		}
		
		$this->setup[$className] = $setup;
	}
	
	/**
	 * @param string $className
	 * @return array
	 */
	public function get($className) {
		return $this->setup[$className];
	}
}