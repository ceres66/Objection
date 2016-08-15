<?php
namespace Objection\Setup;


use Objection\LiteSetup;
use Objection\Enum\VarType;


class ValueValidationTest extends \PHPUnit_Framework_TestCase
{
	public function test_fixValue_Scalars() 
	{
		$this->assertSame(1.0, ValueValidation::fixValue(LiteSetup::createDouble(), "1"));
		$this->assertSame(23, ValueValidation::fixValue(LiteSetup::createInt(), "23"));
		$this->assertSame("1", ValueValidation::fixValue(LiteSetup::createString(), 1));
		$this->assertSame(false, ValueValidation::fixValue(LiteSetup::createBool(), []));
	}
	
	public function test_fixValue_Array() 
	{
		$this->assertEquals([1], ValueValidation::fixValue(LiteSetup::createArray(), 1));
		$this->assertEquals([1, 2], ValueValidation::fixValue(LiteSetup::createArray(), [1, 2]));
	}
	
	public function test_fixValue_Mixed() 
	{
		$this->assertEquals($this, ValueValidation::fixValue(LiteSetup::createMixed(), $this));
	}
	
	
	public function test_fixValue_Enum() 
	{
		$this->assertSame('a', ValueValidation::fixValue(LiteSetup::createEnum(['a', 'b']), 'a'));
	}
	
	
	public function test_fixValue_DateTime_DatePassed()
	{
		$d = new \DateTime('2015-03-06 00:01:02');
		$this->assertEquals($d, ValueValidation::fixValue(LiteSetup::createDateTime(), $d));
	}
	
	public function test_fixValue_DateTime_ObjectIsCloned()
	{
		$d = new \DateTime('2015-03-06 00:01:02');
		$this->assertNotSame($d, ValueValidation::fixValue(LiteSetup::createDateTime(), $d));
	}
	
	public function test_fixValue_DateTime_StringPassedAndConvertedToDateObject()
	{
		$d = new \DateTime('2015-03-06 00:01:02');
		$this->assertEquals($d, ValueValidation::fixValue(LiteSetup::createDateTime(), '2015-03-06 00:01:02'));
	}
	
	public function test_fixValue_DateTime_IntPassedAndUsedAsUnixtimestmap()
	{
		$timestamp = strtotime('2015-03-06 00:01:02');
		$d = new \DateTime('2015-03-06 00:01:02');
		$this->assertEquals($d, ValueValidation::fixValue(LiteSetup::createDateTime(), $timestamp));
	}
	
	/**
	 * @expectedException \Objection\Exceptions\InvalidDatetimeValueTypeException
	 */
	public function test_fixValue_DateTime_InvalidTypePassed_ErrorThrown()
	{
		ValueValidation::fixValue(LiteSetup::createDateTime(), 0.4);
	}
	
	/**
	 * @expectedException \Objection\Exceptions\InvalidDatetimeValueTypeException
	 */
	public function test_fixValue_DateTime_InvalidObjectPassed_ErrorThrown()
	{
		ValueValidation::fixValue(LiteSetup::createDateTime(), new \stdClass());
	}
	
	
	/**
	 * @expectedException \Objection\Exceptions\InvalidEnumValueTypeException
	 */
	public function test_fixValue_InvalidEnumValue_ThrowException() 
	{
		ValueValidation::fixValue(LiteSetup::createEnum(['a', 'b']), 'c');
	}
	
	
	public function test_fixValue_Null() 
	{
		$this->assertNull(ValueValidation::fixValue(LiteSetup::create(VarType::BOOL, true, true), null));
		$this->assertNull(ValueValidation::fixValue(LiteSetup::createEnum(['a', 'b'], null, true), null));
		$this->assertNull(ValueValidation::fixValue(LiteSetup::create(VarType::MIXED, $this, true), null));
	}
	
	
	public function test_fixValue_InstanceOf() 
	{
		$this->assertSame($this, ValueValidation::fixValue(LiteSetup::createInstanceOf(self::class), $this));
	}
	
	/**
	 * @expectedException \Objection\Exceptions\InvalidValueTypeException
	 */
	public function test_fixValue_InvalidInstanceType_ExceptionThrown() 
	{
		ValueValidation::fixValue(LiteSetup::createInstanceOf(self::class), new \stdClass());
	}
}