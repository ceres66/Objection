<?php
namespace Objection\Internal\Properties\MutatorParameters\Types;


use Objection\Internal\Properties\MutatorParameters\Base\AbstractParameterType;


class ClassType extends AbstractParameterType
{
	public function __construct($className)
	{
		parent::__construct(false, false, $className);
	}
}