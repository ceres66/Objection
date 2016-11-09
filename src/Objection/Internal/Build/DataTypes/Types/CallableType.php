<?php
namespace Objection\Internal\Build\DataTypes\Types;


use Objection\Internal\Build\DataTypes\Base\AbstractDataType;


class CallableType extends AbstractDataType
{
	public function __construct()
	{
		parent::__construct(false, false, 'callable');
	}
}