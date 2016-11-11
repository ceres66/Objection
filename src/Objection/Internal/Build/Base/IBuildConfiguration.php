<?php
namespace Objection\Internal\Build\Base;


interface IBuildConfiguration
{
	/**
	 * @param IParserRegistry $registry
	 */
	public function addParsers(IParserRegistry $registry);
}