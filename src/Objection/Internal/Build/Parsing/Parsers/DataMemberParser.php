<?php
namespace Objection\Internal\Build\Parsing\Parsers;


use Objection\Internal\Build\Base\Parsing\AbstractPropertyParser;
use Objection\Internal\Build\DataTypes\TypeFactory;
use Objection\Internal\Build\Parsing\AnnotationExtractor;
use Objection\Internal\PropertyAccessFlags;
use Objection\Exceptions\LiteObjectException;


class DataMemberParser extends AbstractPropertyParser
{
	/**
	 * @param \ReflectionProperty $reflectionProperty
	 */
	private function parseReflectionProperty(\ReflectionProperty $reflectionProperty)
	{
		$comment = $reflectionProperty->getDocComment();
		$annotationProperties = AnnotationExtractor::getProperties($comment);
		$flags = 0;
		
		if (AnnotationExtractor::has($comment, 'ReadOnly') ||
			AnnotationExtractor::has($comment, 'GetOnly'))
		{
			$flags = $flags | PropertyAccessFlags::GET_ONLY;
		}
		
		if (AnnotationExtractor::has($comment, 'WriteOnly') ||
			AnnotationExtractor::has($comment, 'SetOnly'))
		{
			$flags = $flags | PropertyAccessFlags::SET_ONLY;
		}
		
		foreach ($annotationProperties as $annotation)
		{
			$property = $this->getOrCreateProperty($annotation->getName());
			
			if ($property->getMember())
			{
				throw new \Exception("Data member for the property {$property->getName()} " . 
					"is already defined as {$property->getMember()->getFullName()}");
			}
			
			$property->setFlags($flags);
			
			foreach ($annotation->getTypes() as $type)
			{
				$typeObject = TypeFactory::instance()->get($type);
				$property->addType($typeObject);
			}
		}
	}
	
	
	public function parse()
	{
		foreach ($this->getClass()->getProperties() as $reflectionProperty)
		{
			try
			{
				$this->parseReflectionProperty($reflectionProperty);
			}
			catch (\Exception $e)
			{
				throw new LiteObjectException(
					"Error when parsing property " . $reflectionProperty->getName() . 
						" of class " . $this->getClass()->getName() . ": " . $e->getMessage(),
					0,
					$e);
			}
		}
	}
}