<?php
namespace Objection\Internal\Properties\PropertyMethodParameters\Base;


abstract class AbstractParameterType implements IParameterType
{
	private $name;
	private $isArray;
	private $isBuiltIn;
	private $isNullable;
	
	
	/**
	 * @param $name
	 */
	protected function setName($name)
	{
		$this->name = $name;
	}


	/**
	 * @param bool $isBuiltIn
	 * @param bool $isArray
	 * @param string $name
	 */
	public function __construct($isBuiltIn, $isArray, $name = 'undefined')
	{
		$this->isBuiltIn = $isBuiltIn;
		$this->isArray = $isArray;
		$this->name = $name;
	}


	/**
	 * @return string
	 */
	public function name()
	{
		return $this->name;
	}
	
	/**
	 * @return bool
	 */
	public function isBuiltIn()
	{
		return $this->isBuiltIn;
	}
	
	/**
	 * @return bool
	 */
	public function isArray()
	{
		return $this->isArray;
	}

	/**
	 * @param bool $isNullable
	 */
	public function setInNullable($isNullable)
	{
		$this->isNullable = $isNullable;
	}

	/**
	 * @return bool
	 */
	public function isNullable()
	{
		return $this->isNullable;
	}
}