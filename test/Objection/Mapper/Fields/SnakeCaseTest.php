<?php
namespace Objection\Mapper\Fields;


class SnakeCaseTest extends \PHPUnit_Framework_TestCase
{
	public function test_map_EmptyString_EmptyStringReturned()
	{
		$this->assertEquals('', (new SnakeCase())->map(''));
	}
	
	public function test_map_NoChangesNeeded_SameStringReturned()
	{
		$this->assertEquals('abc', (new SnakeCase())->map('abc'));
	}
	
	public function test_map_StringWithNumbers_SameStringReturned()
	{
		$this->assertEquals('ab12c', (new SnakeCase())->map('ab12c'));
	}
	
	public function test_map_FirstCharacterUpperCase()
	{
		$this->assertEquals('abc', (new SnakeCase())->map('Abc'));
	}
	
	public function test_map_CharacterUpperCase()
	{
		$this->assertEquals('a_bc', (new SnakeCase())->map('aBc'));
	}
	
	public function test_map_LowerSpace()
	{
		$this->assertEquals('a_bc', (new SnakeCase())->map('a_bc'));
	}
	
	public function test_map_NumberOfUppercaseCharacters()
	{
		$this->assertEquals('a_bc_def', (new SnakeCase())->map('aBcDef'));
	}
	
	public function test_map_NumberOfUppercaseCharactersTogether()
	{
		$this->assertEquals('a_bc', (new SnakeCase())->map('aBC'));
	}
}