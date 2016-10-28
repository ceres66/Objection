<?php
namespace Objection\Internal\Properties\PropertyMethodParameters\Types;


use Objection\Internal\Properties\PropertyMethodParameters\Base\AbstractParameterType;


class ClassType extends AbstractParameterType
{
	public function __construct($className)
	{
		parent::__construct(false, false, $className);
	}
}