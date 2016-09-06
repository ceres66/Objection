<?php
namespace Objection\Mapper;


use Objection\Mapper\Base\IMapperCollection;
use Objection\Mapper\Base\Fields\IBidirectionalMapper;
use Objection\Exceptions\LiteObjectException;


class MapperCollection implements IMapperCollection
{
	/** @var IBidirectionalMapper */
	private $default;
	
	/** @var IBidirectionalMapper[] */
	private $mappers = [];
	
	
	/**
	 * @param IBidirectionalMapper|null $default
	 */
	public function __construct(IBidirectionalMapper $default = null)
	{
		$this->default = $default;
	}
	
	
	/**
	 * @return IBidirectionalMapper
	 */
	public function getDefault()
	{
		return $this->default;
	}
	
	/**
	 * @param IBidirectionalMapper $mapper
	 * @return static
	 */
	public function setDefault(IBidirectionalMapper $mapper)
	{
		$this->default = $mapper;
		return $this;
	}
	
	/**
	 * @param string $className
	 * @return bool
	 */
	public function has($className)
	{
		return isset($this->mappers[$className]);
	}
	
	/**
	 * @param string $className
	 * @return IBidirectionalMapper|null
	 */
	public function get($className)
	{
		return (isset($this->mappers[$className]) ?
			$this->mappers[$className] : 
			null);
	}
	
	/**
	 * @param string $className
	 * @return IBidirectionalMapper|null
	 */
	public function getOrDefault($className)
	{
		if (isset($this->mappers[$className]))
		{
			return $this->mappers[$className];
		}
		else if ($this->default)
		{
			return $this->default;
		}
		else
		{
			throw new LiteObjectException("No mapper defined for class '$className'");
		}
	}
	
	/**
	 * @param string $className
	 * @param IBidirectionalMapper $mapper
	 * @return static
	 */
	public function set($className, IBidirectionalMapper $mapper)
	{
		$this->mappers[$className] = $mapper;
		return $this;
	}
}