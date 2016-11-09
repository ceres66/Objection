<?php
namespace Objection\Internal\Build\DataTypes\Types;


use Objection\Internal\Build\DataTypes\Base\AbstractDataType;


class MixedType extends AbstractDataType
{
	public function __construct()
	{
		parent::__construct(false, false, 'mixed');
	}
	
	
	/**
	 * @return bool
	 */
	public function isMixed()
	{
		return true;
	}
}