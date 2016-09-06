<?php
namespace Objection\Mapper\Base;


interface IObjectToTargetBuilder
{
	/**
	 * @return IObjectToTargetBuilder
	 */
	public function createBuilder();
	
	/**
	 * @param string $key
	 * @param mixed $value
	 * @return static
	 */
	public function set($key, $value);
	
	/**
	 * Add a new sub set of values under the key. The returned values will be a new builder.
	 * @param string $key
	 * @return IObjectToTargetBuilder
	 */
	public function addChild($key);
	
	/**
	 * @return mixed The built target.
	 */
	public function get();
}