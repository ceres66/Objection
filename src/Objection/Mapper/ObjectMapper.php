<?php
namespace Objection\Mapper;


use Objection\Enum\VarType;
use Objection\LiteObject;
use Objection\Enum\SetupFields;
use Objection\Setup\Container;
use Objection\Mapper\Base\IMapperCollection;
use Objection\Mapper\Base\IObjectToTargetBuilder;
use Objection\Mapper\Base\Extensions\IMappedObject;
use Objection\Exceptions\LiteObjectException;


class ObjectMapper
{
	use \Objection\TStaticClass;
	
	
	/**
	 * @param LiteObject|IMappedObject $object
	 * @return array
	 */
	private static function getFields(LiteObject $object)
	{
		if ($object instanceof IMappedObject)
		{
			return $object->getObjectData();
		}
		else
		{
			return $object->toArray();
		}
	}
	
	/**
	 * @param LiteObject $object
	 * @param array $data
	 * @return LiteObject
	 */
	private static function setFields(LiteObject $object, $data)
	{
		if ($object instanceof IMappedObject)
		{
			$object->setObjectData($data);
		}
		else
		{
			$data = array_intersect_key($data, array_flip($object->getPropertyNames()));
			$object->fromArray($data);
		}
		
		return $object;
	}
	
	
	/**
	 * @param LiteObject $object
	 * @param IMapperCollection $collection
	 * @param \stdClass|array|null $value
	 * @return mixed
	 * @throws LiteObjectException
	 */
	private static function getObjectFromData(LiteObject $object, IMapperCollection $collection, $value)
	{
		$data = [];
		$fieldMapper = $collection->getOrDefault($object);
		$setup = Container::instance()->get(get_class($object));
		
		foreach ($value as $dataName => $dataValue)
		{
			$fieldName = $fieldMapper->mapToObjectField($dataName, get_class($object));
			
			if (!isset($setup[$fieldName]))
			{
				throw new LiteObjectException("Property $fieldName is not defined in " . get_class($object));
			}
			
			$fieldSetup = $setup[$fieldName];
			
			if (isset($fieldSetup[SetupFields::INSTANCE_TYPE]))
			{
				$instanceType = $fieldSetup[SetupFields::INSTANCE_TYPE];
				
				if ($fieldSetup[SetupFields::TYPE] == VarType::INSTANCE)
				{
					$fieldValue = new $instanceType;
					self::getObjectFromData($fieldValue, $collection, $dataValue);
				}
				else
				{
					$fieldValue = [];
					
					foreach ($dataValue as $itemKey => $item)
					{
						$instance = new $instanceType;
						self::getObjectFromData($instance, $collection, $item);
						$fieldValue[$itemKey] = $instance;
					}
				}
			}
			else
			{
				$fieldValue = $dataValue;
			}
			
			$data[$fieldName] = $fieldValue;
		}
		
		return self::setFields($object, $data);
	}
	
	private static function getDataFromLiteObject(IMapperCollection $collection, IObjectToTargetBuilder $builder, LiteObject $value)
	{
		$fieldMapper = $collection->getOrDefault($value);
		$fields = self::getFields($value);
		
		foreach ($fields as $fieldName => $fieldValue)
		{
			$dataField = $fieldMapper->mapFromObjectField($fieldName);
			
			if (!is_object($fieldValue) && !is_array($fieldValue))
			{
				$builder->set($dataField, $fieldValue);
			}
			else 
			{
				$builder->set($dataField, self::getDataFromValue($collection, $builder, $fieldValue));
			}
		}
		
		return $builder->get();
	}
	
	private static function getDataFromArray(IMapperCollection $collection, IObjectToTargetBuilder $builder, array $value)
	{
		$result = [];
		
		foreach ($value as $key => $item)
		{
			$result[$key] = self::getDataFromValue($collection, $builder, $item);
		}
		
		return $result;
	}
	
	private static function getDataFromValue(IMapperCollection $collection, IObjectToTargetBuilder $builder, $value)
	{
		if (is_array($value))
		{
			return self::getDataFromArray($collection, $builder, $value);
		}
		else if (!is_object($value))
		{
			return $value;
		}
		else if ($value instanceof LiteObject)
		{
			$childBuilder = $builder->createBuilder();
			return self::getDataFromLiteObject($collection, $childBuilder, $value);
		}
		
		throw new LiteObjectException("Unsupported object in map: " . get_class($value));
	}
	
	
	/**
	 * @param LiteObject|LiteObject[] $object
	 * @param IMapperCollection $collection
	 * @param IObjectToTargetBuilder $builder
	 * @return mixed
	 */
	public static function fromObject($object, IMapperCollection $collection, IObjectToTargetBuilder $builder)
	{
		return self::getDataFromValue($collection, $builder, $object);
	}
	
	/**
	 * @param string $className
	 * @param array|\stdClass|string $data
	 * @param IMapperCollection $collection
	 * @return LiteObject
	 */
	public static function toObject($className, $data, IMapperCollection $collection)
	{
		if (is_string($data))
		{
			$decodedData = json_decode($data);
			
			if (!$decodedData)
			{
				$errorData = substr($data, 0, 32);
				
				if (strlen($data) > 32) $errorData .= '...';
				
				throw new LiteObjectException("Data is not a json string: '$errorData'");
			}
			
			$data = $decodedData;
		}
		
		return self::getObjectFromData(new $className(), $collection, $data);
	}
}