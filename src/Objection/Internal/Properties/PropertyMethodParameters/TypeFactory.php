<?php
namespace Objection\Internal\Properties\PropertyMethodParameters;


use Objection\Internal\Properties\PropertyMethodParameters\Types;
use Objection\Internal\Properties\PropertyMethodParameters\Base\ITypeFactory;
use Objection\Internal\Properties\PropertyMethodParameters\Base\IParameterType;

use Objection\Exceptions\Build\MultiDimensionalArrayParameterNotSupportedException;


class TypeFactory implements ITypeFactory
{
	use \Objection\TSingleton;
	
	
	/**
	 * @param string $type
	 * @return bool
	 */
	private function isArraySubType($type)
	{
		if (strlen($type) < 3)
			return false;
		
		return (substr($type, strlen($type - 2)) == '[]');
	}

	/**
	 * @param string $type
	 * @return IParameterType
	 */
	private function getArrayType($type)
	{
		$subTypeName = substr($type, 0, strlen($type) - 2);
		
		try
		{
			$subType = $this->get($subTypeName);
		}
		catch (MultiDimensionalArrayParameterNotSupportedException $e)
		{
			throw new MultiDimensionalArrayParameterNotSupportedException($type);
		}
		
		if ($subType instanceof Types\ArrayType)
		{
			throw new MultiDimensionalArrayParameterNotSupportedException($type);
		}
		
		return new Types\ArrayType($subType);
	}
	
	
	/**
	 * @param string $type
	 * @return IParameterType
	 */
	public function get($type)
	{
		if (is_callable($type))
		{
			return new Types\CallableType();
		}
		else if (class_exists($type))
		{
			return new Types\ClassType($type);
		}
		else if ($this->isArraySubType($type))
		{
			return $this->getArrayType($type);
		}
		
		switch ($type)
		{
			case '*':
			case 'mixed':
				return new Types\MixedType();
			
			case 'double':
			case 'string':
			case 'boolean':
			case 'integer':
				return Types\BuiltInType::create($type);
			
			case '[]':
			case 'array':
				return new Types\ArrayType();
		}
		
		throw new \Exception("Could not resolve the type '$type'");
	}
}