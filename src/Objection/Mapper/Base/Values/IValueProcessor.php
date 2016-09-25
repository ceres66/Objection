<?php
namespace Objection\Mapper\Base\Values;


interface IValueProcessor
{
	/**
	 * @param mixed $rawValue
	 * @return mixed
	 */
	public function toObjectValue($rawValue);
	
	/**
	 * @param mixed $rawValue
	 * @return mixed
	 */
	public function toRawValue($rawValue);
}