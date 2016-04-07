<?php
namespace Objection;


class TestObject_TPrivateCallbackTest
{
	use TPrivateCallback;
	
	
	public $isCalled = false;
	public $params = [];
	
	
	/**
	 * @return \Closure
	 */
	public function getFunction() 
	{
		return $this->createCallback('callMe');
	}
	
	/** @noinspection PhpUnusedPrivateMethodInspection
	 * @param $a
	 * @param $b
	 */
	private function callMe($a, $b)
	{
		$this->params = [$a, $b];
		$this->isCalled = true;
	}
}


class TPrivateCallbackTest extends \PHPUnit_Framework_TestCase
{
	public function test_Sanity() 
	{
		$a = new TestObject_TPrivateCallbackTest();
		$func = $a->getFunction();
		
		$func(1, 'b');
		
		$this->assertTrue($a->isCalled);
		$this->assertEquals([1, 'b'], $a->params);
	}
}