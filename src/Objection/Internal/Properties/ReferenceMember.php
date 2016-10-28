<?php
namespace Objection\Internal\Properties;


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
}