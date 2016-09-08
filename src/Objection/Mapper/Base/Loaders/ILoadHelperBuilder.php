<?php
namespace Objection\Mapper\Base\Loaders;


interface ILoadHelperBuilder
{
	/**
	 * @param array|string $fields
	 * @return static
	 */
	public function includeOnly($fields);
	
	/**
	 * @param array|string $fields
	 * @return static
	 */
	public function excludeAny($fields);
	
	/**
	 * @param string $dataName
	 * @param string $objectName
	 * @return static
	 */
	public function mapDataField($dataName, $objectName);
	
	/**
	 * @param string $objectName
	 * @param array|string $variations
	 * @return static
	 */
	public function fieldVariations($objectName, $variations);
}