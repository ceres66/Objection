<?php
namespace Objection\Internal\Build\Parsing;



class EmptyClass
{
	private $empty;
	
	public function emptyMethod()
	{
		
	}
}

/**
 * @property mixed $prop
 */
class SinglePropertyClass
{
	public static $prop_name = 'prop';
	public static $prop_types = ['mixed'];
}


class AnnotationExtractorTest extends \PHPUnit_Framework_TestCase
{
	public function test_getProperties_EmptyClass_EmptyArrayReturned()
	{
		$result = AnnotationExtractor::getProperties(new \ReflectionClass(EmptyClass::class));
		$this->assertSame([], $result);
	}
	
	public function test_getProperties_SingleProperty_ArrayWithOneElementReturned()
	{
		$result = AnnotationExtractor::getProperties(new \ReflectionClass(SinglePropertyClass::class));
		$this->assertCount(1, $result);
	}
}