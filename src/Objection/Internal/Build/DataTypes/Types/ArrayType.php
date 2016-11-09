<?php
namespace Objection\Internal\Build\DataTypes\Types;


use Objection\Internal\Build\DataTypes\Base\IDataType;
use Objection\Internal\Build\DataTypes\Base\AbstractDataType;


class ArrayType extends AbstractDataType
{
	/** @var IDataType */
	private $subType;
	
	
	public function __construct(IDataType $subType = null)
	{
		parent::__construct(false, false, 'array');
		$this->subType = $subType ?: new MixedType();
	}


	/**
	 * @return bool
	 */
	public function isTyped()
	{
		return ($this->subType instanceof MixedType);
	}

	/**
	 * @return IDataType
	 */
	public function getSubType()
	{
		return $this->subType;
	}
}