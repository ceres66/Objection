<?php
namespace Objection\Internal\Build\Parsing;


use Objection\Internal\Build\Annotations\PropertyAnnotation;


class AnnotationExtractor
{
	use \Objection\TStaticClass;


	/**
	 * @param string $name
	 * @return string[][]
	 */
	private static function extract($name, $doc)
	{
		$result = [];
		$regex = "/^[ \\t]*\\*[ \\t]*@{$name}[ \\t]+(.*)$/mi";
		preg_match_all($regex, $doc, $matches);
		
		foreach ($matches[1] as $match)
		{
			if (!$match) continue;
			
			$matchedString = str_replace("\t", ' ', $match);
			$description = array_filter(explode(' ', $matchedString));
			
			if (!$description) continue;
			
			$result[] = $description;
		}
		
		return $result;
	}

	/**
	 * @param \ReflectionClass $source
	 * @param array $description
	 * @return PropertyAnnotation
	 */
	private static function createPropertyAnnotation(\ReflectionClass $source, array $description)
	{
		if ($description[0][0] == '$' || count($description) == 1)
		{
			$types = [];
			$name = $description[0];
		}
		else 
		{
			$types = explode('|', $description[0]);
			$name = $description[1];
		}
		
		if ($name[0] == '$')
		{
			$name = substr($name, 1);
		}
		
		return new PropertyAnnotation($source, $name, $types);
	}
	

	/**
	 * @param \ReflectionClass $source
	 * @return PropertyAnnotation[]
	 */
	public static function getProperties(\ReflectionClass $source)
	{
		$comment = $source->getDocComment();
		$result = [];
		
		foreach (self::extract('property', $comment) as $item)
		{
			$result[] = self::createPropertyAnnotation($source, $item);
		}
		
		return $result;
	}

	/**
	 * @param \ReflectionClass|\ReflectionMethod|\ReflectionProperty $source
	 * @param string $annotation
	 * @return bool
	 */
	public static function has($source, $annotation)
	{
		$regex = "/^[ \\t]*\\*[ \\t]*@{$annotation}([ \\t]+(.*))?$/mi";
		return (1 === preg_match($regex, $source->getDocComment()));
	}
}