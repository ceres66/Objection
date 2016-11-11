<?php
namespace Objection\Internal\Build\Config;


use Objection\Internal\Build\Base\IBuildConfiguration;
use Objection\Internal\Build\Base\IParserRegistry;
use Objection\Internal\Build\Parsing\Parsers\ClassCommentParser;
use Objection\Internal\Build\Parsing\Parsers\DataMemberParser;


class DefaultBuildConfig implements IBuildConfiguration
{
	/**
	 * @param IParserRegistry $registry
	 */
	public function addParsers(IParserRegistry $registry)
	{
		$registry
			->register(ClassCommentParser::class)
			->register(DataMemberParser::class);
	}
}