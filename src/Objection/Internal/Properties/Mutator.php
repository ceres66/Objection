<?php
namespace Objection\Internal\Properties;


use Objection\Internal\Properties\MutatorParameters\Base\IParameterType;
use Objection\Internal\Properties\MutatorParameters\TypeFactory;

class Mutator 
{
	private $mutatorType;
	
	/** @var IParameterType[] */
	private $handledTypes = [];
	
	/** @var \ReflectionMethod */
	private $mutatorMethod;

	
	private function parseParameter()
	{
		$parameter = $this->mutatorMethod->getParameters();
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
			throw new \Exception("Mutator can't have more then 1 parameter!");
		
		$this->mutatorMethod = $method;
		$this->mutatorType = ($paramsCount ? MutatorType::SET : MutatorType::GET);
		
		if ($paramsCount == 1)
		{
			$this->parseParameter();
		}
	}
	
	
	/**
	 * @return \ReflectionMethod
	 */
	public function getMutatorMethod()
	{
		return $this->mutatorMethod;
	}

	/**
	 * @return bool
	 */
	public function isSetter()
	{
		return $this->mutatorType == MutatorType::SET;
	}

	/**
	 * @return bool
	 */
	public function isGetter()
	{
		return $this->mutatorType == MutatorType::GET;
	}

	/**
	 * @return int
	 */
	public function getMutatorType()
	{
		return $this->mutatorType;
	}

	/**
	 * @param IParameterType[] $types
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
	 * @return IParameterType[]
	 */
	public function getHandledTypes()
	{
		return $this->handledTypes;
	}
}