<?php
namespace Objection\Internal\Build;


class emptyClass
{
	
}

/**
 * @property int $A
 */
class classPropertiesClass
{
	
}


class ParserTest extends \PHPUnit_Framework_TestCase
{
	public function test_parse_EmptyClass_NoPropertiesFound()
	{
		$parser = new Parser();
		$this->assertEmpty($parser->parse(emptyClass::class));
	}
}