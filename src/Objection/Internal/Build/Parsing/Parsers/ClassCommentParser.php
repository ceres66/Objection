<?php
namespace Objection\Internal\Build\Parsing\Parsers;


use Objection\Internal\Build\Base\Parsing\AbstractPropertyParser;
use Objection\Internal\Build\Parsing\AnnotationExtractor;
use Objection\Internal\Build\DataTypes\TypeFactory;


class ClassCommentParser extends AbstractPropertyParser
{
	public function parse()
	{
		$propertyAnnotations = AnnotationExtractor::getProperties($this->getClass());
		
		foreach ($propertyAnnotations as $annotation)
		{
			$property = $this->getOrCreateProperty($annotation->getName());
			
			foreach ($annotation->getTypes() as $type)
			{
				$typeObject = TypeFactory::instance()->get($type);
				$property->addType($typeObject);
			}
		}
	}
}