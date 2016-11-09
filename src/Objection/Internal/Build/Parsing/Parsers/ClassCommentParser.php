<?php
namespace Objection\Internal\Build\Parsing\Parsers;


use Objection\Internal\Base\Parsing\AbstractPropertyParser;
use Objection\Internal\Build\Parsing\AnnotationExtractor;


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
				
			}
		}
	}
}