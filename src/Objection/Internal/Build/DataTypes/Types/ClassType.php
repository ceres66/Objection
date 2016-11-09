<?php
namespace Objection\Internal\Build\DataTypes\Types;


use Objection\Internal\Build\DataTypes\Base\AbstractDataType;


class ClassType extends AbstractDataType
{
	public function __construct($className)
	{
		parent::__construct(false, false, $className);
	}
}