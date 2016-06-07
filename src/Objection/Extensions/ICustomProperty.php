<?php
namespace Objection\Extensions;


use Objection\LiteObject;


interface ICustomProperty
{
	public function __clone();
	
	/**
	 * @param LiteObject $object
	 */
	public function bind(LiteObject $object);
	
	/**
	 * @param mixed $value
	 */
	public function set($value);
	
	/**
	 * @return mixed
	 */
	public function get();
}