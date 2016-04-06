<?php
namespace Objection\Utils;


class ExceptionsTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @expectedException  \Exception
	 */
	public function test_throwNoProperty() 
	{
		Exceptions::throwNoProperty($this, 'a');
	}
	
	/**
	 * @expectedException \Exception
	 */
	public function test_throwNotSetProperty() 
	{
		Exceptions::throwNotSetProperty($this, 'b');
	}
	
	/**
	 * @expectedException \Exception
	 */
	public function test_throwNotGetProperty()
	{
		Exceptions::throwNotGetProperty($this, 'b');
	}
}