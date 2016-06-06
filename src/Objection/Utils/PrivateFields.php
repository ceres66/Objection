<?php
namespace Objection\Utils;


use Objection\Enum\SetupFields;
use Objection\Setup\ValueValidation;
use Objection\Exceptions\PropertyNotFoundException;


class PrivateFields
{
	/** @var array */
	private $ref_data;
	
	/** @var array */
	private $setup;
	
	/** @var mixed */
	private $parent;
	
	
	/**
	 * @param array $ref_data
	 * @param array $setup
	 * @param mixed $parent
	 */
	public function __construct(array &$ref_data, array $setup, $parent)
	{
		$this->ref_data =& $ref_data;
		$this->setup	= $setup;
		$this->parent	= $parent;
	}
	
	
	/**
	 * @param string $field
	 * @return mixed
	 */
	public function &__get($field) 
	{
		if (!isset($this->setup[$field]))
			throw new PropertyNotFoundException($this->parent, $field);
		
		return $this->ref_data[$field];
	}
	
	/**
	 * @param string $field
	 * @param mixed $value
	 */
	public function __set($field, $value) 
	{
		if (!isset($this->setup[$field]))
			throw new PropertyNotFoundException($this->parent, $field);
		
		$value = ValueValidation::fixValue($this->setup[$field], $value);
		$this->ref_data[$field] = $value;
	}
	
	/**
	 * @param string $name
	 * @return bool
	 */
	public function __isset($name) 
	{
		return isset($this->setup[$name]);
	}
}