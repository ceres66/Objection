<?php
namespace Objection\Internal\Build\Descriptors;


use Objection\Internal\Build\DataTypes\Base\IDataType;
use Objection\Internal\Build\DataTypes\TypeFactory;


class PropertyMethod 
{
	private $type;
	
	/** @var IDataType[] */
	private $handledTypes = [];
	
	/** @var \ReflectionMethod */
	private $method;

	
	private function parseParameter()
	{
		$parameter = $this->method->getParameters();
		$parameter = $parameter[0];
		
		if ($parameter->getClass())
		{
			$this->handledTypes = [TypeFactory::instance()->get($parameter->getClass())];
		} 
		// PHP 7 and higher
		else if (method_exists($parameter, 'hasType') && $parameter->hasType())
		{
			$type = $parameter->getType();
			$this->handledTypes = [TypeFactory::instance()->get((string)$type)];
		}
	}
	

	/**
	 * @param \ReflectionMethod $method
	 */
	public function __construct(\ReflectionMethod $method)
	{
		$paramsCount = $method->getNumberOfParameters();
		
		if ($paramsCount > 1)
			throw new \Exception("Property method can't have more then 1 parameter!");
		
		$this->method = $method;
		$this->type = ($paramsCount ? PropertyMethodType::MUTATOR : PropertyMethodType::ACCESSOR);
		
		if ($paramsCount == 1)
		{
			$this->parseParameter();
		}
	}
	
	
	/**
	 * @return \ReflectionMethod
	 */
	public function getMethod()
	{
		return $this->method;
	}

	/**
	 * @return bool
	 */
	public function isMutator()
	{
		return $this->type == PropertyMethodType::MUTATOR;
	}

	/**
	 * @return bool
	 */
	public function isAccessor()
	{
		return $this->type == PropertyMethodType::ACCESSOR;
	}

	/**
	 * @return int
	 */
	public function getType()
	{
		return $this->type;
	}

	/**
	 * @param IDataType[] $types
	 */
	public function setHandledTypes(array $types)
	{
		$this->handledTypes = $types;
	}

	/**
	 * @return bool
	 */
	public function hasHandledTypes()
	{
		return (bool)$this->handledTypes;
	}

	/**
	 * @return int
	 */
	public function getHandledTypesCount()
	{
		return count($this->handledTypes);
	}

	/**
	 * @return IDataType[]
	 */
	public function getHandledTypes()
	{
		return $this->handledTypes;
	}
}