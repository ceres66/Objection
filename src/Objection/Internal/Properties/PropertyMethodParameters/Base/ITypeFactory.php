<?php
namespace Objection\Internal\Properties\PropertyMethodParameters\Base;


interface ITypeFactory
{
	/**
	 * @param string $type
	 * @return IParameterType
	 */
	public function get($type);
}