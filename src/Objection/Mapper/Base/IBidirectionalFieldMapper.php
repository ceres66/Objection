<?php
namespace Objection\Mapper\Base;


interface IBidirectionalMapper
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