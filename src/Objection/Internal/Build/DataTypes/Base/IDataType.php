<?php
namespace Objection\Internal\Build\DataTypes\Base;


interface IDataType
{
	/**
	 * @return string
	 */
	public function name();

	/**
	 * @return bool
	 */
	public function isBuiltIn();

	/**
	 * @return bool
	 */
	public function isArray();

	/**
	 * @param bool $isNullable
	 */
	public function setInNullable($isNullable);
	
	/**
	 * @return bool
	 */
	public function isNullable();
	
	/**
	 * @return bool
	 */
	public function isMixed();
	
	/**
	 * @param IDataType $type
	 * @return bool
	 */
	public function isEquals(IDataType $type);
}