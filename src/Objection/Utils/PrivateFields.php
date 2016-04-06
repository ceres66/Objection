<?php
namespace Objection\Utils;


use Objection\Enum\SetupFields;
use Objection\Setup\ValueValidation;


class PrivateFields
{
	/** @var array */
	private $ref_data;
	
	/** @var mixed */
	private $parent;
	
	
	public function __construct(&$ref_data, $parent)
	{
		$this->ref_data = &$ref_data;
		$this->parent = $parent;
	}
	
	
	/**
	 * @param string $field
	 * @return mixed
	 */
	public function &__get($field) 
	{
		if (!isset($this->ref_data[$field]))
			Exceptions::throwNoProperty($this->parent, $field);
		
		return $this->ref_data[$field][SetupFields::VALUE];
	}
	
	/**
	 * @param string $field
	 * @param mixed $value
	 */
	public function __set($field, $value) 
	{
		if (!isset($this->ref_data[$field]))
			Exceptions::throwNoProperty($this->parent, $field);
		
		$value = ValueValidation::fixValue($this->ref_data[$field], $value);
		$this->ref_data[$field][SetupFields::VALUE] = $value;
	}
	
	/**
	 * @param string $name
	 * @return bool
	 */
	public function __isset($name) 
	{
		return isset($this->ref_data[$name]);
	}
}