<?php
namespace Objection\Mapper\Base;


interface IFieldMapper
{
	/**
	 * @param string $field
	 * @return string|bool
	 */
	public function map($field);
}