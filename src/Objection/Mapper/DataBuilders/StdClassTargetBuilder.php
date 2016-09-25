<?php
namespace Objection\Mapper\DataBuilders;


use Objection\Mapper\Base\IObjectToTargetBuilder;


class StdClassTargetBuilder implements IObjectToTargetBuilder
{
	/** @var \stdClass */
	private $data;
	
	
	public function __construct() 
	{
		$this->data = new \stdClass();
	}
	
	
	/**
	 * @return IObjectToTargetBuilder
	 */
	public function createBuilder()
	{
		return new StdClassTargetBuilder();
	}
	
	/**
	 * @param string $key
	 * @param mixed $value
	 * @return static
	 */
	public function set($key, $value)
	{
		$this->data->$key = $value;
	}
	
	/**
	 * @param string $key
	 * @return mixed
	 */
	public function getValue($key)
	{
		return $this->data->$key;
	}
	
	/**
	 * Add a new sub set of values under the key. The returned values will be a new builder.
	 * @param string $key
	 * @return IObjectToTargetBuilder
	 */
	public function addChild($key)
	{
		$object = new StdClassTargetBuilder();
		$this->data->$key = new \stdClass();
		$object->data = $this->data->$key;
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