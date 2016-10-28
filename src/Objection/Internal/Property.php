<?php
namespace Objection\Internal;


use Objection\Internal\Type\ObjectType;
use Objection\Internal\Properties\MethodsSet;
use Objection\Internal\Properties\PropertyMethod;
use Objection\Internal\Properties\ReferenceMember;


class Property
{
	private $name;
	private $flags = null;
	
	/** @var MethodsSet */
	private $accessor;
	
	/** @var MethodsSet */
	private $mutators;
	
	/** @var ReferenceMember */
	private $member;
	
	/** @var ObjectType */
	private $types;


	/**
	 * @param string $name
	 */
	public function __construct($name)
	{
		if (!$name)
			throw new \Exception('Property name can not be empty string!');
		
		$this->name = $name;
	}


	/**
	 * @param int $flags
	 */
	public function setFlags($flags)
	{
		$this->flags = $flags;
	}
	
	/**
	 * @return null|int
	 */
	public function getFlags()
	{
		return $this->flags;
	}
	
	/**
	 * @return bool
	 */
	public function hasFlags()
	{
		return !is_null($this->flags);
	}

	/**
	 * @return MethodsSet
	 */
	public function mutators()
	{
		return $this->mutators;
	}

	/**
	 * @return MethodsSet
	 */
	public function accessors()
	{
		return $this->accessor;
	}

	/**
	 * @return bool
	 */
	public function hasSetters()
	{
		return !$this->mutators->isEmpty();
	}

	/**
	 * @return bool
	 */
	public function hasAccessors()
	{
		return !$this->accessor->isEmpty();
	}

	/**
	 * @param PropertyMethod $mutator
	 */
	public function addMethod(PropertyMethod $mutator)
	{
		if ($mutator->isAccessor())
		{
			$this->accessor->add($mutator);
		}
		else
		{
			$this->mutators->add($mutator);
		}
	}

	/**
	 * @return ReferenceMember
	 */
	public function getMember()
	{
		return $this->member;
	}

	/**
	 * @param ReferenceMember $member
	 */
	public function setMember(ReferenceMember $member)
	{
		$this->member = $member;
	}

	/**
	 * @return bool
	 */
	public function hasMember()
	{
		return !is_null($this->member);
	}
	
	/**
	 * @return string
	 */
	public function getName()
	{
		return $this->name;
	}
	
	/**
	 * @return bool
	 */
	public function canGet()
	{
		return $this->flags !== PropertyAccessFlags::GET_ONLY;
	}
	
	/**
	 * @return bool
	 */
	public function canSet()
	{
		return $this->flags !== PropertyAccessFlags::GET_ONLY;
	}
}