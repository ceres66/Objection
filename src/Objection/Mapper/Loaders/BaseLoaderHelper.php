<?php
namespace Objection\Mapper\Loaders;


use Objection\Mapper\Base\Loaders\ILoadHelper;


class BaseLoaderHelper implements ILoadHelper
{	
	/**
	 * @param array $fields Keys of $data
	 * @param array $data The entire object data
	 * @return array|null New set of fields, or null when no changes needed.
	 */
	public function filterFields(array $fields, array $data)
	{
		return null;
	}
	
	/**
	 * @param array $data The entire object data
	 * @return array The new data object with mapped fields.
	 */
	public function mapFields(array $data)
	{
		return $data;
	}
}