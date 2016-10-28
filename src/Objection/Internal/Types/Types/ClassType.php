<?php
namespace Objection\Internal\Types\Types;


use Objection\Internal\Types\Base\AbstractDataType;


class ClassType extends AbstractDataType
{
	public function __construct($className)
	{
		parent::__construct(false, false, $className);
	}
}