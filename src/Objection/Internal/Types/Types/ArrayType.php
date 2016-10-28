<?php
namespace Objection\Internal\Types\Types;


use Objection\Internal\Types\Base\IDataType;
use Objection\Internal\Types\Base\AbstractDataType;


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