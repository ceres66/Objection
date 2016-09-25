<?php
namespace Objection\Mapper\ValuesProcessor;


use Objection\Mapper\Base\Values\IValueProcessor;


class ArrayToStringValueProcessor implements IValueProcessor
{
	private $glue;
	
	
	/**
	 * @param string $glue
	 */
	public function __construct($glue = ',')
	{
		$this->glue = $glue;
	}
	
	
	/**
	 * @param mixed $rawValue
	 * @return mixed
	 */
	public function toObjectValue($rawValue)
	{
		return explode($this->glue, $rawValue);
	}
	
	/**
	 * @param mixed $rawValue
	 * @return mixed
	 */
	public function toRawValue($rawValue)
	{
		return implode($this->glue, $rawValue);
	}
}