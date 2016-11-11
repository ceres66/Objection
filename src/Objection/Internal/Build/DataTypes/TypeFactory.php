<?php
namespace Objection\Internal\Build\DataTypes;


use Objection\Internal\Build\DataTypes\Types;
use Objection\Internal\Build\DataTypes\Base\IDataType;
use Objection\Internal\Build\DataTypes\Base\ITypeFactory;
use Objection\Internal\Build\DataTypes\Base\INamespaceParser;

use Objection\Exceptions\Build\MultiDimensionalArrayParameterNotSupportedException;


class TypeFactory implements ITypeFactory
{
	/** @var INamespaceParser|null */
	private $namespaceParser = null;
	
	
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
	 * @return IDataType|null
	 */
	private function tryGetGeneric($type)
	{
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
			
			case 'callable':
				return new Types\CallableType();
			
			default:
				return null;
		}
	}

	/**
	 * @param string $type
	 * @return Types\ClassType|null
	 */
	private function tryGetFullClassName($type)
	{
		if (!$this->namespaceParser)
			return null;
		
		$className = $this->namespaceParser->resolveNamespaceFor($type);
			
		if (!$className && !class_exists($className))
		{
			return null;
		}
		
		return new Types\ClassType($className);
	}


	/**
	 * @param INamespaceParser|null $namespaceParser
	 */
	public function __construct(INamespaceParser $namespaceParser = null)
	{
		$this->namespaceParser = $namespaceParser;
	}


	/**
	 * @param string $type
	 * @return IDataType
	 */
	public function get($type)
	{
		if (class_exists($type))
		{
			return new Types\ClassType($type);
		}
		else if ($this->isArraySubType($type))
		{
			return $this->getArrayType($type);
		}
		
		$dataType = $this->tryGetGeneric($type);
		
		if (!$dataType)
		{
			$dataType = $this->tryGetFullClassName($type);;
		}
		
		if (!$dataType)
		{
			throw new \Exception("Could not resolve the type '$type'");
		}
		
		return $dataType;
	}
}