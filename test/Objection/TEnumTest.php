<?php
namespace Objection;


class TestObject_TEnumTest 
{
	use TEnum;
	
	
	const A = 'a';
	const B = 2;
	const ARR = ['1', '2'];
	
	public static $NOT_CONST = 5;
}


class TEnumTest extends \PHPUnit_Framework_TestCase
{
	public function test_getAll()
	{
		$this->assertEquals(
			[
				'a',
				2
			],
			TestObject_TEnumTest::getAll()
		);
	}
	
	
	public function test_isExists()
	{
		$this->assertTrue(TestObject_TEnumTest::isExists('a'));
		$this->assertTrue(TestObject_TEnumTest::isExists(2));
		$this->assertFalse(TestObject_TEnumTest::isExists('b'));		
		$this->assertFalse(TestObject_TEnumTest::isExists(3));		
	}
	
	
	public function test_isExists_SameValueButDifferentType()
	{
		$this->assertFalse(TestObject_TEnumTest::isExists('2'));
		$this->assertFalse(TestObject_TEnumTest::isExists(2.0));
	}
	
	
	public function test_getCount()
	{
		$this->assertEquals(2, TestObject_TEnumTest::getCount());
	}
}