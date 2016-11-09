<?php
namespace Objection\Internal\Build\DataTypes;


use Objection\Internal\Build\DataTypes\Types;
use Objection\Internal\Build\DataTypes\Base\ITypeFactory;
use Objection\Internal\Build\DataTypes\Base\IDataType;

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
	 * @return IDataType
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
	 * @return IDataType
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
			
			case 'bool':
			case 'boolean':
				return Types\BuiltInType::boolean();
			
			case 'float':
			case 'double':
				return Types\BuiltInType::double();
			
			case 'int':
			case 'integer':
				return Types\BuiltInType::integer();
				
			case 'string':
				return Types\BuiltInType::string();
			
			case '[]':
			case 'array':
				return new Types\ArrayType();
		}
		
		throw new \Exception("Could not resolve the type '$type'");
	}
}