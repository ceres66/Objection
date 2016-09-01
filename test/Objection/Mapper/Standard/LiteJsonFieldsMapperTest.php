<?php
namespace Objection\Mapper\Standard;


use Objection\LiteSetup;
use Objection\LiteObject;


class LiteJsonFieldsMapperTest extends \PHPUnit_Framework_TestCase
{
	public function test_passFieldsAsArray()
	{
		$obj = new LiteJsonFieldsMapper(['A', 'B']);
		$this->assertEquals('A', $obj->mapToObjectField('a'));
	}
	
	public function test_passFieldsAsObject()
	{
		$obj = new LiteJsonFieldsMapper(new Test_LiteJsonMapperTest_Helper());
		$this->assertEquals('A', $obj->mapToObjectField('a'));
	}
	
	public function test_sanity()
	{
		$obj = new LiteJsonFieldsMapper(['ABcdE', 'efgh']);
		
		$this->assertEquals('ABcdE', $obj->mapToObjectField('aBcdE'));
		$this->assertEquals('aBcdE', $obj->mapFromObjectField('ABcdE'));
	}
}


class Test_LiteJsonMapperTest_Helper extends LiteObject
{
	/**
	 * @return array
	 */
	protected function _setup()
	{
		return [
			'A'	=> LiteSetup::createString(),
			'B'	=> LiteSetup::createString()
		];
	}
}