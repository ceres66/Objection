<?php
namespace Objection\Mapper\Base;


interface IBidirectionalFieldMapper
{
	/**
	 * @param string $rowField
	 * @return string
	 */
	public function mapToObjectField($rowField);
	
	/**
	 * @param string $objectField
	 * @return string 
	 */
	public function mapFromObjectField($objectField);
}