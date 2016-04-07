<?php
namespace Objection;


class TestObject_TSingleton
{
	use TSingleton;
	
	
	public static $initializeParameter = null;
	public static $initializeCallCount = 0;
	
	
	protected static function initialize($calledWith) 
	{
		self::$initializeCallCount++;
		self::$initializeParameter = $calledWith;
	}
}


class TSingletonTest extends \PHPUnit_Framework_TestCase
{
	public function test_SameInstance()
	{
		$this->assertSame(TestObject_TSingleton::instance(), TestObject_TSingleton::instance());
	}
	
	public function test_initializeCalled()
	{
		TestObject_TSingleton::instance();
		TestObject_TSingleton::instance();
		
		$this->assertSame(TestObject_TSingleton::instance(), TestObject_TSingleton::$initializeParameter);
		$this->assertEquals(1, TestObject_TSingleton::$initializeCallCount);
	}
}