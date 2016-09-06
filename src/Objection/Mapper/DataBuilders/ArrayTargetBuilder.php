<?php
namespace Objection\Mapper\DataBuilders;


use Objection\Mapper\Base\IObjectToTargetBuilder;


class ArrayTargetBuilder implements IObjectToTargetBuilder
{
	/** @var array */
	private $data = [];
	
	/**
	 * @return IObjectToTargetBuilder
	 */
	public function createBuilder()
	{
		return new ArrayTargetBuilder();
	}
	
	/**
	 * @param string $key
	 * @param mixed $value
	 * @return static
	 */
	public function set($key, $value)
	{
		$this->data[$key] = $value;
	}
	
	/**
	 * Add a new sub set of values under the key. The returned values will be a new builder.
	 * @param string $key
	 * @return IObjectToTargetBuilder
	 */
	public function addChild($key)
	{
		$object = new ArrayTargetBuilder();
		$this->data[$key] = [];
		$object->data = &$this->data[$key];
		
		return $object;
	}
	
	/**
	 * @return mixed The built target.
	 */
	public function get()
	{
		return $this->data;
	}
}