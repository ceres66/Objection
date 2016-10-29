<?php
namespace Objection\Internal\Build\Parsing;


use Objection\Internal\Build\Annotations\PropertyAnnotation;


class AnnotationExtractor
{
	use \Objection\TStaticClass;


	/**
	 * @param \ReflectionClass|\ReflectionMethod|\ReflectionProperty $source
	 * @return PropertyAnnotation[]
	 */
	public static function getProperties($source)
	{
		$comment = $source->getDocComment();
		
		$regex = "/^[ \\t]*\\*[ \\t]*@var ([\\w\\\\]+)[ \\t]+\\$?{$parameterName}.*$/m";
		
		return [];
	}
}