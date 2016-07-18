<?php
namespace Objection\Extensions;


use Objection\LiteObject;


interface ICustomProperty
{
	/**
	 * @return static
	 */
	public function __clone();
	
	/**
	 * @return bool If false, a new instance will be created for each field in each object. 
	 */
	public function isStateless();
	
	/**
	 * @param LiteObject $object
	 * @param mixed $value
	 * @return mixed
	 */
	public function set(LiteObject $object, $value);
	
	/**
	 * @param LiteObject $object
	 * @return mixed
	 */
	public function get(LiteObject $object);
}