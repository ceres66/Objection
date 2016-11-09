<?php
namespace Objection\Internal\Build\Properties;


use Objection\Internal\Property;


class PropertyList
{
	/** @var Property[] */
	private $properties = [];
	
	
	/**
	 * @return bool
	 */
	public function isEmpty()
	{
		return !((bool)$this->properties);
	}
	
	/**
	 * @return int
	 */
	public function count()
	{
		return count($this->properties);
	}

	/**
	 * @param string $name
	 * @return Property|null
	 */
	public function get($name)
	{
		return ($this->has($name) ? 
			$this->properties[$name] : 
			null);
	}
	
	/**
	 * @param string $name
	 * @param Property|null $property
	 * @return bool
	 */
	public function tryGet($name, &$property)
	{
		$property = $this->get($name);
		return (bool)$property;
	}
	
	/**
	 * @param string $name
	 * @return bool
	 */
	public function has($name)
	{
		return isset($this->properties[$name]);
	}
	
	/**
	 * @return Property[]
	 */
	public function all()
	{
		return array_values($this->properties);
	}
	
	/**
	 * @param string $name
	 * @return Property
	 */
	public function getOrCreate($name)
	{
		if (!$this->has($name))
		{
			$this->properties[$name] = new Property($name);
		}
		
		return $this->properties[$name];
	}

	/**
	 * @param Property $property
	 */
	public function add(Property $property)
	{
		if (isset($this->properties[$property->getName()]))
			throw new \Exception("Property with name {$property->getName()} is already in set!");
		
		$this->properties[$property->getName()] = $property;
	}
}