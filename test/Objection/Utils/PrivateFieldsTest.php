<?php
namespace Objection\Utils;


use Objection\Enum\SetupFields;
use Objection\Enum\AccessRestriction;
use Objection\LiteSetup;


class PrivateFieldsTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @expectedException \Exception
	 */
	public function test_get_NoProperty_ErrorThrown() 
	{
		$data = [];
		$p = new PrivateFields($data, $this);
		$a = $p->n;
	}
	
	public function test_get_PropertyExists_PropertyReturned() 
	{
		$data = ['n' => [SetupFields::VALUE => 12], 'a' => [SetupFields::VALUE => 13]];
		$p = new PrivateFields($data, $this);
		
		$this->assertEquals(12, $p->n);
		$this->assertEquals(13, $p->a);
	}
	
	public function test_get_PropertyReturnedByReference() 
	{
		$data = ['n' => [SetupFields::VALUE => 12]];
		$p = new PrivateFields($data, $this);
		
		$val =& $p->n;
		$val = 13;
		
		$this->assertEquals(13, $p->n);
	}
	
	public function test_get_ProperyIsGetOnly_PropertyStillCanBeAccessed() 
	{
		$data = ['n' => [SetupFields::VALUE => 13, SetupFields::ACCESS => AccessRestriction::NO_GET]];
		$p = new PrivateFields($data, $this);
		$this->assertEquals(13, $p->n);
	}
	
	
	/**
	 * @expectedException \Exception
	 */
	public function test_set_NoProperty_ErrorThrown() 
	{
		$data = [];
		$p = new PrivateFields($data, $this);
		$p->n = 5;
	}
	
	public function test_get_PropertyExists_PropertyModifed() 
	{
		$data = [
			'n' => LiteSetup::createInt(12), 
			'a' => LiteSetup::createInt(13)
		];
		$p = new PrivateFields($data, $this);
		
		$p->n = 24;
		$p->a = 25;
		
		$this->assertEquals(24, $p->n);
		$this->assertEquals(25, $p->a);
	}
	
	public function test_get_PropertyValueIsFixed() 
	{
		$data = [
			'n' => LiteSetup::createInt(12),
			'a' => LiteSetup::createArray([])
		];
		
		$p = new PrivateFields($data, $this);
		
		$p->n = "24";
		$p->a = 25;
		
		$this->assertSame(24, $p->n);
		$this->assertEquals([25], $p->a);
	}
	
	
	public function test_isset() 
	{
		$data = ['n' => []];
		
		$p = new PrivateFields($data, $this);
		
		$this->assertTrue(isset($p->n));
		$this->assertFalse(isset($p->a));
	}
}