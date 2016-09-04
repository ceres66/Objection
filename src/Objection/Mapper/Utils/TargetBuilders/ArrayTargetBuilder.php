<?php
namespace Objection\Mapper\Utils\TargetBuilders;


use Objection\Mapper\Base\IObjectToTargetBuilder;


class ArrayTargetBuilder implements IObjectToTargetBuilder
{
	/** @var array */
	private $data = [];
	
	
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
	public function add($key)
	{
		$object = new ArrayTargetBuilder();
		$this->data[$key] = $object;
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