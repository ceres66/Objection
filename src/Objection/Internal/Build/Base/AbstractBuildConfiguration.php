<?php
namespace Objection\Internal\Build\Base;


class AbstractBuildConfiguration implements IBuildConfiguration
{
	/**
	 * @param IParserRegistry $registry
	 */
	public function addParsers(IParserRegistry $registry) {}
}