<?php
namespace Objection\Internal\Properties\MutatorParameters\Types;


use Objection\Internal\Properties\MutatorParameters\Base\AbstractParameterType;


class MixedType extends AbstractParameterType
{
	public function __construct()
	{
		parent::__construct(false, false, 'mixed');
	}
}