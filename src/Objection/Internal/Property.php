<?php
namespace Objection\Internal;


use Objection\Internal\Build\DataTypes\Base\IDataType;
use Objection\Internal\Build\Properties\MethodsSet;
use Objection\Internal\Build\Properties\PropertyMethod;
use Objection\Internal\Build\Properties\ReferenceMember;


class Property
{
	private $name;
	private $flags = null;
	
	
	/** @var IDataType[] */
	private $types;
	
	/** @var ReferenceMember */
	private $member;
	
	/** @var MethodsSet */
	private $accessor;
	
	/** @var MethodsSet */
	private $mutators;


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
	 * @param int $flags
	 */
	public function addFlags($flags)
	{
		$this->flags = ($this->flags | $flags);
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
	 * @return IDataType[]
	 */
	public function getTypes()
	{
		return $this->types;
	}

	/**
	 * @return bool
	 */
	public function hasTypes()
	{
		return (bool)$this->types; 
	}

	/**
	 * @param IDataType $type
	 */
	public function addType(IDataType $type)
	{
		if ($type->isMixed())
		{
			$this->types = [$type];
			return;
		}
		
		foreach ($this->types as $dataType)
		{
			if ($dataType->isMixed() || $type->isEquals($dataType))
			{
				return;
			}
		}
		
		$this->types[] = $type; 
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