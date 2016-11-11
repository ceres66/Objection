<?php
namespace Objection\Internal\Build\Parsing\Parsers;


use Objection\Internal\Build\Base\Parsing\AbstractPropertyParser;
use Objection\Internal\Build\Parsing\AnnotationExtractor;


class ClassCommentParser extends AbstractPropertyParser
{
	public function parse()
	{
		$typeFactory = $this->getTypeFactory();
		$propertyAnnotations = AnnotationExtractor::getProperties($this->getReflectionClass());
		
		foreach ($propertyAnnotations as $annotation)
		{
			$property = $this->getOrCreateProperty($annotation->getName());
			
			foreach ($annotation->getTypes() as $type)
			{
				$typeObject = $typeFactory->get($type);
				$property->addType($typeObject);
			}
		}
	}
}