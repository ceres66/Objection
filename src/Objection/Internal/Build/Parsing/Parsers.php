<?php
namespace Objection\Internal\Build\Parsing;


use Objection\Internal\Build\Base\IParserRegistry;
use Objection\Internal\Build\Base\Parsing\IPropertyParser;
use Objection\Internal\Build\Descriptors\TargetClass;
use Objection\Internal\Build\Descriptors\PropertyList;
use Objection\Exceptions\LiteObjectException;


class Parsers implements IParserRegistry
{
	/** @var IPropertyParser[] */
	private $set = [];
	

	/**
	 * @param IPropertyParser|string $parser
	 * @return static
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
		
		return $this;
	}
	
	/**
	 * @param TargetClass $class
	 * @return PropertyList
	 */
	public function parse(TargetClass $class)
	{
		$propertyList = new PropertyList();
		
		foreach ($this->set as $item)
		{
			$item->setPropertyList($propertyList);
			$item->setTargetClass($class);
			$item->parse();
		}
		
		return $propertyList;
	}
}