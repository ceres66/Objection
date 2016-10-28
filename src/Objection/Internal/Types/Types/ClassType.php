<?php
namespace Objection\Internal\Types\Types;


use Objection\Internal\Types\Base\AbstractParameterType;


class ClassType extends AbstractParameterType
{
	public function __construct($className)
	{
		parent::__construct(false, false, $className);
	}
}