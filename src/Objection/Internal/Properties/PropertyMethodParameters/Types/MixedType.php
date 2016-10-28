<?php
namespace Objection\Internal\Properties\PropertyMethodParameters\Types;


use Objection\Internal\Properties\PropertyMethodParameters\Base\AbstractParameterType;


class MixedType extends AbstractParameterType
{
	public function __construct()
	{
		parent::__construct(false, false, 'mixed');
	}
}