<?php
namespace Objection;


class TestObject_TConstsClassTest 
{
	use TConstsClass;
	
	
	const A = 'a';
	const B = 2;
	const ARR = ['1', '2'];
	
	public static $NOT_CONST = 5;
}


class TConstsClassTest extends \PHPUnit_Framework_TestCase
{
	public function test_getConstsAsArray()
	{
		$this->assertEquals(
			[
				'A'	=> TestObject_TConstsClassTest::A,
				'B'	=> TestObject_TConstsClassTest::B,
				'ARR' => TestObject_TConstsClassTest::ARR
			],
			TestObject_TConstsClassTest::getConstsAsArray()
		);
	}
	
	public function test_getConstNames()
	{
		$this->assertEquals(
			['A', 'B', 'ARR'],
			TestObject_TConstsClassTest::getConstNames()
		);
	}
	
	public function test_getConstValues()
	{
		$this->assertEquals(
			['a', 2, ['1', '2']],
			TestObject_TConstsClassTest::getConstValues()
		);
	}
	
	public function test_getConstsCount()
	{
		$this->assertEquals(3, TestObject_TConstsClassTest::getConstsCount());
	}
	
	public function test_isConstExists()
	{
		$this->assertTrue(TestObject_TConstsClassTest::isConstExists('A'));
		$this->assertFalse(TestObject_TConstsClassTest::isConstExists('NOT_CONST'));
		$this->assertFalse(TestObject_TConstsClassTest::isConstExists('NOT_FOUND'));
	}
	
	public function test_isConstValueExists()
	{
		$this->assertTrue(TestObject_TConstsClassTest::isConstValueExists('a'));
		$this->assertTrue(TestObject_TConstsClassTest::isConstValueExists(['1', '2']));
		$this->assertTrue(TestObject_TConstsClassTest::isConstValueExists(2));
		
		$this->assertFalse(TestObject_TConstsClassTest::isConstValueExists('2'));
		$this->assertFalse(TestObject_TConstsClassTest::isConstValueExists(5));
		$this->assertFalse(TestObject_TConstsClassTest::isConstValueExists(['1', 2]));
	}
}