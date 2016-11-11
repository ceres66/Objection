<?php
namespace Objection\Internal\Build\DataTypes\Base;


interface INamespaceParser
{
	/**
	 * @param string $partial
	 * @return string|bool 
	 */
	public function resolveNamespaceFor($partial);
}