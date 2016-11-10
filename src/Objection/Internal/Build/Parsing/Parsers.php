<?php
namespace Objection\Internal\Build\Parsing;


use Objection\Internal\Build\Base\Parsing\IPropertyParser;
use Objection\Internal\Build\Properties\PropertyList;
use Objection\Exceptions\LiteObjectException;

class Parsers
{
	/** @var IPropertyParser[] */
	private $set;
	
	/** @var PropertyList */
	private $propertyList;


	/**
	 * @param IPropertyParser|string $parser
	 */
	public function register($parser)
	{
		if (is_string($parser))
		{
			if (!class_exists($parser))
			{
				throw new LiteObjectException('Class ' . $parser . ' not found');
			}
			
			$parser = new $parser;
		}
		
		if (!($parser instanceof IPropertyParser))
		{
			throw new LiteObjectException('Object is not an instance of ' . IPropertyParser::class);
		}
		
		$this->set[] = $parser;
	}

	/**
	 * @param PropertyList $list
	 */
	public function setPropertyList(PropertyList $list)
	{
		$this->propertyList = $list;
	}
	
	/**
	 * @param \ReflectionClass $class
	 * @return PropertyList
	 */
	public function parse(\ReflectionClass $class)
	{
		foreach ($this->set as $item)
		{
			$item->setPropertyList($this->propertyList);
			$item->setTargetClass($class);
			$item->parse();
		}
		
		return $this->propertyList;
	}
}