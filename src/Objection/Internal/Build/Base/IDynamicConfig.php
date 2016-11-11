<?php
namespace Objection\Internal\Build\Base;


use Objection\Internal\Build\Base\Parsing\IPropertyParser;


interface IDynamicConfig
{
	/**
	 * @param IPropertyParser|string $parser Parser or parser class name.
	 * @return static
	 */
	public function registerParser($parser);
}