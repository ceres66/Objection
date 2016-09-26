<?php
namespace Objection\Mapper\Utils;


use Objection\Mapper\ValuesProcessor;
use Objection\Mapper\Base\Values\IValueProcessor;
use Objection\Mapper\Base\Values\IObjectValuesProcessor;


class ValuesProcessorCreator
{
	/** @var IObjectValuesProcessor */
	private $objectValuesProcessor;
	
	
	/**
	 * @param IObjectValuesProcessor $processor
	 */
	public function __construct(IObjectValuesProcessor $processor) 
	{
		$this->objectValuesProcessor = $processor;
	}
	
	
	/**
	 * @param string $field
	 * @param string $glue
	 * @return static
	 */
	public function arrayToString($field, $glue = ',')
	{
		$this->objectValuesProcessor->add($field, new ValuesProcessor\ArrayToStringValueProcessor($glue));
		return $this;
	}
	
	/**
	 * @param string $field
	 * @param \Closure $toObject
	 * @param \Closure $toRawData
	 * @return static
	 */
	public function callback($field, $toObject, $toRawData)
	{
		$this->objectValuesProcessor->add($field, new ValuesProcessor\CallbackValueProcessor($toObject, $toRawData));
		return $this;
	}
	
	/**
	 * @param string $field
	 * @param IValueProcessor $processor
	 * @return static
	 */
	public function set($field, IValueProcessor $processor)
	{
		$this->objectValuesProcessor->add($field, $processor);
		return $this;
	}
}