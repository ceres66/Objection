<?php
namespace Objection\Internal\Types\Types;


use Objection\Internal\Types\Base\AbstractDataType;


class CallableType extends AbstractDataType
{
	public function __construct()
	{
		parent::__construct(false, false, 'callable');
	}
}