<?php
namespace Objection\Internal\Build\Descriptors;


use Objection\Internal\Property;


class PropertyListTest extends \PHPUnit_Framework_TestCase
{
	public function test_isEmpty_Empty_ReturnTrue()
	{
		$this->assertTrue((new PropertyList())->isEmpty());
	}
	
	public function test_isEmpty_HasProperty_ReturnFalse()
	{
		$list = new PropertyList();
		$list->add(new Property('a'));
		$this->assertFalse($list->isEmpty());
	}
	
	
	public function test_count_Empty_Return0()
	{
		$list = new PropertyList();
		$this->assertSame(0, $list->count());
	}
	
	public function test_count_HasItems_ReturnCount()
	{
		$list = new PropertyList();
		$list->add(new Property('a'));
		$list->add(new Property('b'));
		$this->assertSame(2, $list->count());
	}
	
	
	public function test_get_EmptyList_ReturnNull()
	{
		$list = new PropertyList();
		$this->assertNull($list->get('a'));
	}
	
	public function test_get_ItemNotFound_ReturnNull()
	{
		$list = new PropertyList();
		$list->add(new Property('b'));
		$list->add(new Property('c'));
		$this->assertNull($list->get('a'));
	}
	
	public function test_get_ItemFound_ReturnItem()
	{
		$target = new Property('a');
		$list = new PropertyList();
		
		$list->add(new Property('b'));
		$list->add($target);
		$list->add(new Property('c'));
		
		$this->assertSame($target, $list->get('a'));
	}
	
	
	public function test_tryGet_EmptyList_ReturnFalse()
	{
		$list = new PropertyList();
		$this->assertFalse($list->tryGet('a', $result));
	}
	
	public function test_tryGet_PropertyNotFound_ReturnFalse()
	{
		$list = new PropertyList();
		$list->add(new Property('b'));
		$list->add(new Property('c'));
		$this->assertFalse($list->tryGet('a', $result));
	}
	
	public function test_tryGet_PropertyNotFound_PropertySetToNull()
	{
		$list = new PropertyList();
		
		$list->add(new Property('b'));
		$list->add(new Property('c'));
		$list->tryGet('a', $result);
		
		$this->assertNull($result);
	}
	
	public function test_get_PropertyFound_ReturnTrue()
	{
		$list = new PropertyList();
		$list->add(new Property('b'));
		$list->add(new Property('a'));
		$this->assertTrue($list->tryGet('a', $result));
	}
	
	public function test_get_PropertyFound_ReturnProperty()
	{
		$target = new Property('a');
		$list = new PropertyList();
		
		$list->add(new Property('b'));
		$list->add($target);
		$list->add(new Property('c'));
		
		$list->tryGet('a', $result);
		
		$this->assertSame($target, $result);
	}
	
	
	public function test_has_EmptyList_ReturnFalse()
	{
		$list = new PropertyList();
		$this->assertFalse($list->has('a'));
	}
	
	public function test_has_NotFound_ReturnFalse()
	{
		$list = new PropertyList();
		$list->add(new Property('b'));
		$list->add(new Property('c'));
		$this->assertFalse($list->has('a'));
	}
	
	public function test_has_Found_ReturnTrue()
	{
		$list = new PropertyList();
		$list->add(new Property('b'));
		$list->add(new Property('a'));
		$this->assertTrue($list->has('a'));
	}
	
	
	public function test_all_Empty_ReturnEmptyArray()
	{
		$list = new PropertyList();
		$this->assertSame([], $list->all());
	}
	
	public function test_all_ItemsExists_ArrayOfItemsReturned()
	{
		$list = new PropertyList();
		$a = new Property('a');
		$b = new Property('b');
		
		$list->add($a);
		$list->add($b);
		
		$this->assertSame([$a, $b], $list->all());
	}
	
	
	public function test_getOrCreate_EmptyList_NewItemReturned()
	{
		$list = new PropertyList();
		$this->assertInstanceOf(Property::class, $list->getOrCreate('a'));
	}
	
	public function test_getOrCreate_ItemNotInList_NewItemReturned()
	{
		$list = new PropertyList();
		$list->add(new Property('b'));
		$this->assertInstanceOf(Property::class, $list->getOrCreate('a'));
	}
	
	public function test_getOrCreate_ItemNotInList_PropertyNameIsCorrect()
	{
		$list = new PropertyList();
		$list->add(new Property('b'));
		
		$property = $list->getOrCreate('a');
		
		$this->assertSame('a', $property->getName());
	}
	
	public function test_getOrCreate_ItemNotInList_NewItemAddedToTheList()
	{
		$list = new PropertyList();
		$list->getOrCreate('a');
		$this->assertEquals(1, $list->count());
	}
	
	public function test_getOrCreate_ItemInList_ExistingItemReturned()
	{
		$target = new Property('a');
		$list = new PropertyList();
		
		$list->add($target);
		
		$this->assertSame($target, $list->getOrCreate('a'));
	}
	
	public function test_getOrCreate_ItemInList_NoNewItemsAddToList()
	{
		$target = new Property('a');
		$list = new PropertyList();
		
		$list->add($target);
		$list->getOrCreate('a');
		
		$this->assertEquals(1, $list->count());
	}
	
	
	public function test_add_EmptyList_ItemAdded()
	{
		$target = new Property('a');
		$list = new PropertyList();
		
		$list->add($target);
		
		$this->assertEquals(1, $list->count());
		$this->assertSame($target, $list->get('a'));
	}
	
	public function test_add_NotEmptyList_ItemAdded()
	{
		$target = new Property('a');
		$list = new PropertyList();
		
		$list->add(new Property('b'));
		$list->add($target);

		$this->assertEquals(2, $list->count());
		$this->assertSame($target, $list->get('a'));
	}

	/**
	 * @expectedException \Exception
	 */
	public function test_add_ItemAlreadyInList_ThrowException()
	{
		$target = new Property('a');
		$list = new PropertyList();
		
		$list->add(new Property('a'));
		$list->add($target);
	}
}