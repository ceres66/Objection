<?php
namespace Objection\Internal\Type;


use Objection\Internal\Type\ObjectType;

class TypesContainer
{
	use \Objection\TSingleton;
	
	
	/** @var ObjectType[] */
	private $types = [];
	
	
	public function getType($className)
	{
		if (!isset($this->types[$className]))
		{
			// TODO: Load
		}
		
		return $this->types[$className];
	}
}