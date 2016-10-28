<?php
namespace Objection\Internal\Types\Base;


interface ITypeFactory
{
	/**
	 * @param string $type
	 * @return IParameterType
	 */
	public function get($type);
}