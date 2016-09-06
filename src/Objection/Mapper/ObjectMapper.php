<?php
namespace Objection\Mapper;


use Objection\Exceptions\LiteObjectException;
use Objection\LiteObject;
use Objection\Mapper\Base\IMapperCollection;
use Objection\Mapper\Base\IObjectToTargetBuilder;
use Objection\Mapper\Base\Extensions\IMappedObject;


class ObjectMapper
{
	use \Objection\TStaticClass;
	
	
	/**
	 * @param LiteObject $object
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
			$object->fromArray($data);
		}
		
		return $object;
	}
	
	
	/**
	 * @param LiteObject|LiteObject[] $object
	 * @param IMapperCollection $collection
	 * @param IObjectToTargetBuilder $builder
	 * @return mixed
	 */
	public static function fromObject($object, IMapperCollection $collection, IObjectToTargetBuilder $builder)
	{
		if (is_array($object))
		{
			$result = [];
			
			foreach ($object as $item)
			{
				$itemBuilder = clone $builder;
				self::fromObject($item, $collection, $itemBuilder);
				$result[] = $builder->get();
			}
			
			return $result;
		}
		
		$fieldMapper = $collection->getOrDefault($object);
		$fields = self::getFields($object);
		
		foreach ($fields as $fieldName => $value)
		{
			$dataField = $fieldMapper->mapFromObjectField($fieldName);
			$builder->set($dataField, $value);
		}
		
		return $builder->get();
	}
	
	/**
	 * @param string $className
	 * @param array|\stdClass|string $data
	 * @param IMapperCollection $collection
	 * @return LiteObject
	 */
	public static function toObject($className, $data, IMapperCollection $collection)
	{
		$objectData		= [];
		$fieldMapper	= $collection->getOrDefault($className);
		
		if (is_string($data))
		{
			$decodedData = json_decode($data);
			
			if (!$decodedData)
			{
				$errorData = substr($data, 0, 32);
				
				if (strlen($data) > 32) $errorData .= '...';
				
				throw new LiteObjectException("Data is not a json string: '$errorData'");
			}
		}
		
		foreach ($data as $dataField => $value)
		{
			$objectField = $fieldMapper->mapToObjectField($dataField);
			$objectData[$objectField] = $value; 
		}
		
		return self::setFields(new $className(), $objectData);
	}
}