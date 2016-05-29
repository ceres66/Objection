<?php
namespace Objection;


use Objection\Enum\AccessRestriction;


/**
 * @property int	$PropInt
 * @property string	$PropString
 * @property array	$PropArray
 * @property int	$PropGetOnly
 * @property int 	$PropSetOnly
 * @property int	$OnSetProperty
 */
class TestObject_LiteObject extends LiteObject 
{
	public $onSetValue = null;
	
	
	/**
	 * @return array
	 */
	protected function _setup()
	{
		return [
			'PropInt'		=> LiteSetup::createInt(),
			'PropString'	=> LiteSetup::createString('a'),
			'PropArray'		=> LiteSetup::createArray([]),
			'PropGetOnly'	=> LiteSetup::createInt(0, AccessRestriction::NO_SET),
			'PropSetOnly'	=> LiteSetup::createInt(0, AccessRestriction::NO_GET),
			'OnSetProperty'	=> LiteSetup::createInt()
		];
	}
	
	
	/**
	 * @return static
	 */
	public function getPrivateAccess() 
	{
		return $this->_p;
	}
	
	public function onSetOnSetProperty($value) 
	{
		$this->onSetValue = $value;
	}
}


class LiteObjectTest extends \PHPUnit_Framework_TestCase
{
	public function test_PropertyExists_PropertyModified() 
	{
		$o = new TestObject_LiteObject();
		$o->PropString = "abc";
		
		$this->assertEquals("abc", $o->PropString);
	}
	
	public function test_PropertyExists_PropertyTypeFixed() 
	{
		$o = new TestObject_LiteObject();
		$o->PropString = 1;
		
		$this->assertSame("1", $o->PropString);
	}
	
	/**
	 * @expectedException \Objection\Exceptions\PropertyNotFoundException 
	 */
	public function test_PropertyDoesNotExits_ErrorThrown() 
	{
		$o = new TestObject_LiteObject();
		
		/** @noinspection PhpUndefinedFieldInspection */
		$o->PropNone = "1";
	}
	
	
	/**
	 * @expectedException \Objection\Exceptions\ReadOnlyPropertyException 
	 */
	public function test_SetGetOnlyProperty_ErrorThrown() 
	{
		$o = new TestObject_LiteObject();
		$o->PropGetOnly = "1";
	}
	
	public function test_Get_GetOnlyProperty() 
	{
		$o = new TestObject_LiteObject();
		$this->assertEquals(0, $o->PropGetOnly);
	}
	
	
	/**
	 * @expectedException \Objection\Exceptions\WriteOnlyPropertyException
	 */
	public function test_GetSetOnlyProperty_ErrorThrown() 
	{
		$o = new TestObject_LiteObject();
		
		/** @noinspection PhpUnusedLocalVariableInspection */
		$a = $o->PropSetOnly;
	}
	
	public function test_Set_SetOnlyProperty() 
	{
		$o = new TestObject_LiteObject();
		$o->PropSetOnly = 5;
	}
	
	
	public function test_Set_CallbackMethodCalled() 
	{
		$o = new TestObject_LiteObject();
		$o->OnSetProperty = 5;
		$this->assertEquals(5, $o->onSetValue);
	}
	
	public function test_Set_CallbackMethodCalledWithCorrectValueType() 
	{
		$o = new TestObject_LiteObject();
		$o->OnSetProperty = "5";
		$this->assertEquals(5, $o->onSetValue);
	}
	
	
	public function test_ReturnByReferenceWorks() 
	{
		$o = new TestObject_LiteObject();
		$o->PropArray[] = 5;
		$o->PropArray[] = "6";
		$this->assertEquals([5, "6"], $o->PropArray);
	}
	
	/**
	 * @expectedException \PHPUnit_Framework_Error_Notice
	 */
	public function test_GetOnlyProperty_NotReturnedByReference() 
	{
		$o = new TestObject_LiteObject();
		
		/** @noinspection PhpUnusedLocalVariableInspection */
		$a =& $o->PropGetOnly;
	}
	
	public function test_PrivateModifier() 
	{
		$o = new TestObject_LiteObject();
		$p = $o->getPrivateAccess();
		$p->PropInt = "4";
		
		$this->assertSame(4, $o->PropInt);
	}
	
	
	public function test_toArray() 
	{
		$o = new TestObject_LiteObject();
		$this->assertEquals(
			[
				'PropInt'		=> $o->PropInt,
				'PropGetOnly'	=> $o->PropGetOnly,
				'PropArray'		=> $o->PropArray,
				'PropString'	=> $o->PropString,
				'OnSetProperty'	=> $o->OnSetProperty
			],
			$o->toArray());
	}
	
	public function test_toArray_WithFiler() 
	{
		$o = new TestObject_LiteObject();
		$this->assertEquals(
			[
				'PropString'	=> $o->PropString,
				'PropInt'		=> $o->PropInt
			],
			$o->toArray(['PropString', 'PropInt']));
	}
	
	public function test_toArray_WithFiler_OrderSameAsFilter() 
	{
		$o = new TestObject_LiteObject();
		$this->assertEquals(
			['PropString', 'PropInt'],
			array_keys($o->toArray(['PropString', 'PropInt'])));
	}
	
	public function test_toArray_WithExclude() 
	{
		$o = new TestObject_LiteObject();
		$this->assertEquals(
			[
				'PropInt'		=> $o->PropInt,
				'PropGetOnly'	=> $o->PropGetOnly,
				'PropArray'		=> $o->PropArray
			],
			$o->toArray([], ['OnSetProperty', 'PropString']));
	}
	
	/**
	 * @expectedException \Objection\Exceptions\PropertyNotFoundException
	 */
	public function test_toArray_FilterForInvalidProperty_ErrorThrown() 
	{
		$o = new TestObject_LiteObject();
		$o->toArray(['a']);
	}
	
	public function test_toArray_FilterForSetOnlyProperty_PropertyIgnored() 
	{
		$o = new TestObject_LiteObject();
		$d = $o->toArray(['PropSetOnly']);
		$this->assertFalse(isset($d['PropGetOnly']));
	}
	
	
	public function test_fromArray() 
	{
		$o = new TestObject_LiteObject();
		$o->fromArray(['PropInt' => "5", 'PropString' => "A"]);
		
		$this->assertSame(5, $o->PropInt);
		$this->assertSame("A", $o->PropString);
	}
	
	/**
	 * @expectedException \Objection\Exceptions\PropertyNotFoundException
	 */
	public function test_fromArray_DoesNotExists_ErrorThrown() 
	{
		$o = new TestObject_LiteObject();
		$o->fromArray(['dd' => "5"]);
	}
	
	public function test_fromArray_GetOnlyPropertyIgnored() 
	{
		$o = new TestObject_LiteObject();
		$o->fromArray(['PropGetOnly' => "5"]);
	}
	
	/**
	 * @expectedException \Objection\Exceptions\ReadOnlyPropertyException
	 */
	public function test_fromArray_IgnoreFlagIsFalse_GetOnlyPropertyNotIgnored()
	{
		$o = new TestObject_LiteObject();
		$o->fromArray(['PropGetOnly' => "5"], false);
	}
	
	
	public function test_getPropertyNames() 
	{
		$o = new TestObject_LiteObject();
		$this->assertEquals(
			[
				'PropInt',
				'PropString',
				'PropArray',
				'PropGetOnly',
				'PropSetOnly',
				'OnSetProperty'
			],
			$o->getPropertyNames());
	}
	
	public function test_getPropertyNames_WithExclude() 
	{
		$o = new TestObject_LiteObject();
		$this->assertEquals(
			['PropInt', 'PropArray', 'PropGetOnly' ],
			$o->getPropertyNames(['PropSetOnly', 'OnSetProperty', 'PropString']));
	}
	
	
	public function test_constructor_ValuesLoaded() 
	{
		$o = new TestObject_LiteObject(['PropInt' => 5, 'PropString' => 6]);
		$this->assertSame(5, $o->PropInt);
		$this->assertSame("6", $o->PropString);
	}
	
	public function test_constructor_SetForGetOnlyPropertyAllowedInConstructor() 
	{
		$o = new TestObject_LiteObject(['PropGetOnly' => 6]);
		$this->assertSame(6, $o->PropGetOnly);
	}
	
	
	public function test_isRestricted() 
	{
		$o = new TestObject_LiteObject();
		$this->assertTrue($o->isRestricted('PropGetOnly'));
		$this->assertFalse($o->isRestricted('PropInt'));
	}
	
	
	public function test_isset() 
	{
		$o = new TestObject_LiteObject();
		$this->assertTrue(isset($o->PropGetOnly));
		$this->assertFalse(isset($o->NotFound));
	}
	
	
	public function test_allToArray()
	{
		$data = [
			new TestObject_LiteObject([
				'PropString'	=> 'str1'
			]),
			new TestObject_LiteObject([
				'PropString'	=> 'str2'
			])
		];
		
		$result = LiteObject::allToArray($data);
		
		$this->assertCount(2, $result);
		$this->assertEquals([$data[0]->toArray(), $data[1]->toArray()], $result);
	}
	
	public function test_allToArray_WithFilters()
	{
		$data = [
			new TestObject_LiteObject([
				'PropString'	=> 'str1'
			]),
			new TestObject_LiteObject([
				'PropString'	=> 'str2'
			])
		];
		
		$result = LiteObject::allToArray($data, ['PropString']);
		
		$this->assertCount(2, $result);
		$this->assertEquals([$data[0]->toArray(['PropString']), $data[1]->toArray(['PropString'])], $result);
	}
	
	public function test_allToArray_WithExclude()
	{
		$data = [
			new TestObject_LiteObject([
				'PropString'	=> 'str1'
			]),
			new TestObject_LiteObject([
				'PropString'	=> 'str2'
			])
		];
		
		$result = LiteObject::allToArray($data, [], ['PropString']);
		
		$this->assertCount(2, $result);
		$this->assertEquals([$data[0]->toArray([], ['PropString']), $data[1]->toArray([], ['PropString'])], $result);
	}
	
	public function test_allFromArray()
	{
		$a = new TestObject_LiteObject(['PropString' => 'str1']);
		$b = new TestObject_LiteObject(['PropString' => 'str2']);
		
		$data = [$a->toArray([], ['PropGetOnly']), $b->toArray([], ['PropInt', 'PropGetOnly'])];
		
		$result = TestObject_LiteObject::allFromArray($data);
		
		$this->assertCount(2, $result);
		$this->assertEquals($a->toArray(), $result[0]->toArray());
		$this->assertEquals($b->toArray(), $result[1]->toArray());
	}
}