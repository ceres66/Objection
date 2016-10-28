<?php
namespace Objection\Internal\Types\Types;


use Objection\Internal\Types\Base\AbstractParameterType;


class MixedType extends AbstractParameterType
{
	public function __construct()
	{
		parent::__construct(false, false, 'mixed');
	}
}