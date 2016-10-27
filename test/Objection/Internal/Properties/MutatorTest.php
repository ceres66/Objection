<?php
namespace Objection\Internal\Properties;


class MutatorTest extends \PHPUnit_Framework_TestCase
{
	private function _setterMethod($dummy) {}
	private function _setterMethodWithArray(array $dummy) {}
	private function _setterMethodWithInt(int $dummy) {}
	private function _getterMethod() {}
	
	
	public function test_constructor_MethodWithOneParameter_MutatorIsSetter()
	{
		$m = new Mutator(new \ReflectionMethod(self::class, "_setterMethod"));
		$this->assertEquals(MutatorType::SET, $m->getMutatorType());
	}
	
	public function test_constructor_MethodWithParameters_MutatorIsGetter()
	{
		$m = new Mutator(new \ReflectionMethod(self::class, "_getterMethod"));
		$this->assertEquals(MutatorType::GET, $m->getMutatorType());
	}
	
	public function test_constructor_MethodHasNoParameterType_NoTypeIsSet()
	{
		$m = new Mutator(new \ReflectionMethod(self::class, "_setterMethod"));
		$this->assertFalse($m->hasHandledTypes());
	}
	
	public function test_constructor_MethodHasParameterType_HandledTypeSet()
	{
		$m = new Mutator(new \ReflectionMethod(self::class, "_setterMethodWithArray"));
		$this->assertTrue($m->hasHandledTypes());
	}
	
	public function test_constructor_MethodHasBuiltInType_HandledTypeSet()
	{
		$m = new Mutator(new \ReflectionMethod(self::class, "_setterMethodWithInt"));
		$this->assertTrue($m->hasHandledTypes());
	}
}