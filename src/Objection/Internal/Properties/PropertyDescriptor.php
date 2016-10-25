<?php
namespace Objection\Internal\Properties;


class PropertyDescriptor
{
	private $name;

	
	/** @var bool */
	private $canSet = true;
	
	/** @var bool */
	private $canGet = true;
	
	
	/** @var \ReflectionMethod|null */
	private $getter = null;
	
	/** @var \ReflectionMethod|null */
	private $setter;
	
	/** @var \ReflectionProperty|null */
	private $property;
	

	/**
	 * @param string $name
	 */
	public function __construct($name)
	{
		$this->name = $name;
	}


	/**
	 * @return string
	 */
	public function name()
	{
		return $this->name;
	}
}