<?php
namespace Objection\Mapper\Utils;


use Objection\Mapper\Base\Values\IObjectValuesProcessor;
use Objection\Mapper\ValuesProcessor;


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
}