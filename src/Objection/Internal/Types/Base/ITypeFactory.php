<?php
namespace Objection\Internal\Types\Base;


interface ITypeFactory
{
	/**
	 * @param string $type
	 * @return IDataType
	 */
	public function get($type);
}