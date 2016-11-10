<?php
namespace Objection\Internal\Build\Descriptors;


class ReferenceMember
{
	/** @var \ReflectionProperty */
	private $member;


	/**
	 * @param \ReflectionProperty $member
	 */
	public function __construct(\ReflectionProperty $member)
	{
		$this->member = $member;
	}


	/**
	 * @return \ReflectionProperty
	 */
	public function getReferenceMember()
	{
		return $this->member;
	}

	/**
	 * @return string
	 */
	public function getMemberName()
	{
		return $this->member->getName();
	}
	
	public function getFullName()
	{
		return $this->member->getDeclaringClass()->getName() . "::" . $this->member->getName();
	}
}