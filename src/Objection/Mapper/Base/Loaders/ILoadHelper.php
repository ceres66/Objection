<?php
namespace Objection\Mapper\Base\Loaders;


interface ILoadHelper
{
	/**
	 * @param array $fields Keys of $data
	 * @param array $data The entire object data 
	 * @return array|null New set of fields, or null when no changes needed.
	 */
	public function filterFields(array $fields, array $data);
	
	/**
	 * @param array $data The entire object data
	 * @return array The new data object with mapped fields.
	 */
	public function mapFields(array $data);
}