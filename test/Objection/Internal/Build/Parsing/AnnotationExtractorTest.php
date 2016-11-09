<?php
namespace Objection\Internal\Build\Parsing;



use Objection\Internal\Build\Parsing\Annotations\PropertyAnnotation;

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

/**
 * @property $prop
 */
class PropertyTypesMissing
{
	public static $prop_name = 'prop';
	public static $prop_types = [];
}

/**
 * @ProPerty $prop
 */
class AnnotationCaseDifferent
{
	public static $prop_name = 'prop';
	public static $prop_types = [];
}

/**
 * @property int prop
 */
class PropertyNameMissingDollarMissing
{
	public static $prop_name = 'prop';
}

/**
 * @property prop
 */
class NoTypesAndNoDollarSign
{
	public static $prop_name = 'prop';
}

/**
 * @property 
 */
class PropertyDescriptionMissing {}

/**
 * @property int|string|* $prop
 */
class NumberOfPropertyTypes 
{
	public static $prop_types = ['int', 'string', '*'];
}

/**
 * @property string $prop1
 * @property int $prop2
 */
class NumberOfProperties 
{
	public static $prop_1_types = ['string'];
	public static $prop_1_name = 'prop1';
	public static $prop_2_types = ['int'];
	public static $prop_2_name = 'prop2';
}


/**
 * @anot
 */
class HasTest_AnnotationExists
{
	
}

/**
 * abc @anot
 */
class HasTest_InvalidAnnotation
{
	
}

/**
 * @anot abc	d
 */
class HasTest_AnnotationWithComment
{
	
}

/**
 * @AnOt
 */
class HasTest_AnnotationCaseIgnored
{
	
}

/**
 * @A
 * @property 
 * @anot
 * @b
 */
class HasTest_NumberOfOtherAnnotationsExist
{
	
}

/**
 * @A
 * @property
 * @b
 */
class HasTest_OtherAnnotationsOnly
{
	
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
	
	public function test_getProperties_AnnotationCaseIgnored()
	{
		$result = AnnotationExtractor::getProperties(new \ReflectionClass(AnnotationCaseDifferent::class));
		$this->assertCount(1, $result);
	}
	
	public function test_getProperties_PropertiesExist_ArrayContainsPropertyAnnotationObjects()
	{
		$result = AnnotationExtractor::getProperties(new \ReflectionClass(SinglePropertyClass::class));
		$this->assertInstanceOf(PropertyAnnotation::class, $result[0]);
	}
	
	public function test_getProperties_SourceClassPassedToPropertyAnnotationObject()
	{
		$source = new \ReflectionClass(SinglePropertyClass::class);
		$result = AnnotationExtractor::getProperties($source);
		$this->assertSame($source, $result[0]->getSourceClass());
	}
	
	public function test_getProperties_PropertyNameResolved()
	{
		$result = AnnotationExtractor::getProperties(new \ReflectionClass(SinglePropertyClass::class));
		$this->assertSame(SinglePropertyClass::$prop_name, $result[0]->getName());
	}
	
	public function test_getProperties_PropertyTypeResolved()
	{
		$result = AnnotationExtractor::getProperties(new \ReflectionClass(SinglePropertyClass::class));
		$this->assertSame(SinglePropertyClass::$prop_types, $result[0]->getTypes());
	}
	
	public function test_getProperties_PropertyTypesMissing_PropertyTypesAreSetToEmptyArray()
	{
		$result = AnnotationExtractor::getProperties(new \ReflectionClass(PropertyTypesMissing::class));
		$this->assertSame(PropertyTypesMissing::$prop_types, $result[0]->getTypes());
	}
	
	public function test_getProperties_PropertyTypesMissing_PropertyNameResolved()
	{
		$result = AnnotationExtractor::getProperties(new \ReflectionClass(PropertyTypesMissing::class));
		$this->assertSame(PropertyTypesMissing::$prop_name, $result[0]->getName());
	}
	
	public function test_getProperties_PropertyNameMissingDollarWithTypesPresent_PropertyNameResolved()
	{
		$result = AnnotationExtractor::getProperties(new \ReflectionClass(PropertyNameMissingDollarMissing::class));
		$this->assertSame(PropertyNameMissingDollarMissing::$prop_name, $result[0]->getName());
	}
	
	public function test_getProperties_TypesAndDollarSignMissing_PropertyNameResolved()
	{
		$result = AnnotationExtractor::getProperties(new \ReflectionClass(NoTypesAndNoDollarSign::class));
		$this->assertSame(NoTypesAndNoDollarSign::$prop_name, $result[0]->getName());
	}
	
	public function test_getProperties_PropertyDescriptionMissing_PropertyIgnored()
	{
		$result = AnnotationExtractor::getProperties(new \ReflectionClass(PropertyDescriptionMissing::class));
		$this->assertSame([], $result);
	}
	
	public function test_getProperties_NumberOfPropertyTypes_AllTypesResolved()
	{
		$result = AnnotationExtractor::getProperties(new \ReflectionClass(NumberOfPropertyTypes::class));
		$this->assertSame(NumberOfPropertyTypes::$prop_types, $result[0]->getTypes());
	}
	
	public function test_getProperties_NumberOfProperties_AllPropertiesLoaded()
	{
		$result = AnnotationExtractor::getProperties(new \ReflectionClass(NumberOfProperties::class));
		$this->assertCount(2, $result);
	}
	
	public function test_getProperties_NumberOfProperties_AllPropertiesCorrect()
	{
		$result = AnnotationExtractor::getProperties(new \ReflectionClass(NumberOfProperties::class));
		
		$this->assertInstanceOf(PropertyAnnotation::class, $result[0]);
		$this->assertSame(NumberOfProperties::$prop_1_name, $result[0]->getName());
		$this->assertSame(NumberOfProperties::$prop_1_types, $result[0]->getTypes());
		
		$this->assertInstanceOf(PropertyAnnotation::class, $result[1]);
		$this->assertSame(NumberOfProperties::$prop_2_name, $result[1]->getName());
		$this->assertSame(NumberOfProperties::$prop_2_types, $result[1]->getTypes());
	}
	
	
	public function test_has_AnnotationMissing_ReturnFalse()
	{
		$this->assertFalse(AnnotationExtractor::has(new \ReflectionClass(EmptyClass::class), 'anot'));
	}
	
	public function test_has_AnnotationExists_ReturnTrue()
	{
		$this->assertTrue(AnnotationExtractor::has(new \ReflectionClass(HasTest_AnnotationExists::class), 'anot'));
	}
	
	public function test_has_AnnotationIncorrect_ReturnFalse()
	{
		$this->assertFalse(AnnotationExtractor::has(new \ReflectionClass(HasTest_InvalidAnnotation::class), 'anot'));
	}
	
	public function test_has_AnnotationWithComment_ReturnTrue()
	{
		$this->assertTrue(AnnotationExtractor::has(new \ReflectionClass(HasTest_AnnotationWithComment::class), 'anot'));
	}
	
	public function test_has_AnnotationCaseIgnored_ReturnTrue()
	{
		$this->assertTrue(AnnotationExtractor::has(new \ReflectionClass(HasTest_AnnotationCaseIgnored::class), 'anot'));
	}
	
	public function test_has_OtherAnnotationsExistAlso_ReturnTrue()
	{
		$this->assertTrue(AnnotationExtractor::has(new \ReflectionClass(HasTest_NumberOfOtherAnnotationsExist::class), 'anot'));
	}
	
	public function test_has_OnlyOtherAnnotationsExist_ReturnFalse()
	{
		$this->assertFalse(AnnotationExtractor::has(new \ReflectionClass(HasTest_OtherAnnotationsOnly::class), 'anot'));
	}
}