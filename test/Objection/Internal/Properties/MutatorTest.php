<?php
namespace Objection\Internal\Build\Descriptors;


class MutatorTest extends \PHPUnit_Framework_TestCase
{
	private function _setterMethod($dummy) {}
	private function _setterMethodWithArray(array $dummy) {}
	private function _setterMethodWithInt(int $dummy) {}
	private function _getterMethod() {}
	
	
	public function test_constructor_MethodWithOneParameter_MutatorIsSetter()
	{
		$m = new PropertyMethod(new \ReflectionMethod(self::class, "_setterMethod"));
		$this->assertEquals(PropertyMethodType::MUTATOR, $m->getType());
	}
	
	public function test_constructor_MethodWithParameters_MutatorIsGetter()
	{
		$m = new PropertyMethod(new \ReflectionMethod(self::class, "_getterMethod"));
		$this->assertEquals(PropertyMethodType::ACCESSOR, $m->getType());
	}
	
	public function test_constructor_MethodHasNoParameterType_NoTypeIsSet()
	{
		$m = new PropertyMethod(new \ReflectionMethod(self::class, "_setterMethod"));
		$this->assertFalse($m->hasHandledTypes());
	}
	
	public function test_constructor_MethodHasParameterType_HandledTypeSet()
	{
		$m = new PropertyMethod(new \ReflectionMethod(self::class, "_setterMethodWithArray"));
		$this->assertTrue($m->hasHandledTypes());
	}
	
	public function test_constructor_MethodHasBuiltInType_HandledTypeSet()
	{
		$m = new PropertyMethod(new \ReflectionMethod(self::class, "_setterMethodWithInt"));
		$this->assertTrue($m->hasHandledTypes());
	}
}