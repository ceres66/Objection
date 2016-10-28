<?php
namespace Objection\Internal\Properties;


class MethodsSet
{
	private $type;
	
	/** @var PropertyMethod[] */
	private $set = [];


	/**
	 * @param int $type
	 */
	public function __construct($type)
	{
		$this->type = $type;
	}


	/**
	 * @return int
	 */
	public function getType()
	{
		return $this->type;
	}

	/**
	 * @return int
	 */
	public function count()
	{
		return count($this->set);
	}

	/**
	 * @return bool
	 */
	public function isEmpty()
	{
		return !((bool)$this->set);
	}

	/**
	 * @return PropertyMethod[]
	 */
	public function getAll()
	{
		return $this->set;
	}

	/**
	 * @param PropertyMethod $method
	 */
	public function add(PropertyMethod $method)
	{
		if ($method->getType() != $this->getType())
			throw new \Exception("Passed method is not of expected type: {$this->getType()}, " . 
				"got {$method->getType()} instead.");
		
		$this->set[] = $method;
	}
}