<?php
namespace Objection\Internal\Properties\MutatorParameters\Base;


interface ITypeFactory
{
	/**
	 * @param string $type
	 * @return IParameterType
	 */
	public function get($type);
}