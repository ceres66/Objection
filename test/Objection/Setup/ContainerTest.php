<?php
namespace Objection\Setup;


class ContainerTest extends \PHPUnit_Framework_TestCase 
{
	/**
     * @runInSeparateProcess
     */
	public function test_has()
	{
		Container::instance()->set('b', []);
		Container::instance()->set('c', []);
		
		$this->assertFalse(Container::instance()->has('a'));
		$this->assertTrue(Container::instance()->has('c'));
	}
	
	
	/**
     * @runInSeparateProcess
     */
	public function test_set()
	{
		$this->assertFalse(Container::instance()->has('b'));
		Container::instance()->set('b', []);
		$this->assertTrue(Container::instance()->has('b'));
	}
	
	/**
     * @runInSeparateProcess
	 * @expectedException \Exception
     */
	public function test_set_ClassAlreadyDefined_ErrorThrown()
	{
		Container::instance()->set('b', []);
		Container::instance()->set('b', []);
	}
	
	/**
     * @runInSeparateProcess
     */
	public function test_get()
	{
		$data = ['a', 'b'];
		Container::instance()->set('b', $data);
		
		$this->assertSame($data, Container::instance()->get('b'));
		$this->assertEquals(null, Container::instance()->get('c'));
	}
	
	
}
