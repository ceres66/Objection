<?php
namespace Objection\Internal\Build\DataTypes\Base;


interface ITypeFactory
{
	/**
	 * @param string $type
	 * @return IDataType
	 */
	public function get($type);
}