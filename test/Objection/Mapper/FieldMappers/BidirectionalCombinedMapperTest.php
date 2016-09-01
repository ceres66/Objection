<?php
namespace Objection\Mapper\FieldMappers;


use Objection\Mapper\Base\IFieldMapper;


class BidirectionalCombinedMapperTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @return \PHPUnit_Framework_MockObject_MockObject|IFieldMapper
	 */
	private function mockIFieldMapper()
	{
		return $this->getMock(IFieldMapper::class);
	}
	
	
	public function test_mapToObjectField_ToObjectMapperCalled()
	{
		$from	= $this->mockIFieldMapper();
		$to		= $this->mockIFieldMapper();
		
		$to->expects($this->once())->method('map')->with('abcd')->willReturn('123');
		
		$this->assertEquals('123', (new BidirectionalCombinedMapper($from, $to))->mapToObjectField('abcd'));
	}
	
	public function test_mapFromObjectField_FromObjectMapperCalled()
	{
		$from	= $this->mockIFieldMapper();
		$to		= $this->mockIFieldMapper();
		
		$from->expects($this->once())->method('map')->with('abcd')->willReturn('123');
		
		$this->assertEquals('123', (new BidirectionalCombinedMapper($from, $to))->mapFromObjectField('abcd'));
	}
}