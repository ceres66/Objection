<?php
namespace Objection\Internal\Build\Base;


use Objection\Internal\Build\Base\Parsing\IPropertyParser;


interface IParserRegistry
{
	/**
	 * @param IPropertyParser|string $parser
	 * @return static
	 */
	public function register($parser);
}