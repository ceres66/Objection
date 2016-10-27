<?php
namespace Objection\Internal\Properties\MutatorParameters\Base;


interface IParameterType
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
}