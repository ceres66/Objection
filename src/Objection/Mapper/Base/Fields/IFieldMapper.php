<?php
namespace Objection\Mapper\Base\Fields;


interface IFieldMapper
{
	/**
	 * @param string $field
	 * @return string|bool
	 */
	public function map($field);
}