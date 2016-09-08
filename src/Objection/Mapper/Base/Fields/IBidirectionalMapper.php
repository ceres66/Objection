<?php
namespace Objection\Mapper\Base\Fields;


interface IBidirectionalMapper
{
	/**
	 * @param string $rowField
	 * @param string $className
	 * @return string
	 */
	public function mapToObjectField($rowField, $className);
	
	/**
	 * @param string $objectField
	 * @return string 
	 */
	public function mapFromObjectField($objectField);
}