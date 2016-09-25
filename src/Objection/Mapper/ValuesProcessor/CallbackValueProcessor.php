<?php
namespace Objection\Mapper\ValuesProcessor;


use Objection\Mapper\Base\Values\IValueProcessor;


class CallbackValueProcessor implements IValueProcessor
{
	/** @var \Closure */
	private $toRaw;
	
	/** @var \Closure */
	private $toObject;
	
	
	/**
	 * @param \Closure $toRaw
	 * @param \Closure $toObject
	 */
	public function __construct($toObject, $toRaw)
	{
		$this->toRaw = $toRaw;
		$this->toObject = $toObject;
	}
	
	
	/**
	 * @param mixed $rawValue
	 * @return mixed
	 */
	public function toObjectValue($rawValue)
	{
		$toObject = $this->toObject;
		return $toObject($rawValue);
	}
	
	/**
	 * @param mixed $rawValue
	 * @return mixed
	 */
	public function toRawValue($rawValue)
	{
		$toRaw = $this->toRaw;
		return $toRaw($rawValue);
	}
}