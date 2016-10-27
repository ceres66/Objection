<?php
namespace Objection\Internal\Properties\MutatorParameters\Types;


use Objection\Internal\Properties\MutatorParameters\Base\IParameterType;
use Objection\Internal\Properties\MutatorParameters\Base\AbstractParameterType;


class ArrayType extends AbstractParameterType
{
	/** @var IParameterType */
	private $subType;
	
	
	public function __construct(IParameterType $subType = null)
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
	 * @return IParameterType
	 */
	public function getSubType()
	{
		return $this->subType;
	}
}