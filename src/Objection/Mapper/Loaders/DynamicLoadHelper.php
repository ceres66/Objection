<?php
namespace Objection\Mapper\Loaders;


use Objection\Mapper\Base\Loaders\ILoadHelper;
use Objection\Mapper\Base\Loaders\ILoadHelperBuilder;


class DynamicLoadHelper implements ILoadHelper, ILoadHelperBuilder
{
	private $exclude	= [];
	private $include	= [];
	private $variations	= [];
	
	
	/**
	 * @param array $fields Keys of $data
	 * @param array $data The entire object data
	 * @return array|null New set of fields, or null when no changes needed.
	 */
	public function filterFields(array $fields, array $data)
	{
		if ($this->include)
		{
			return array_intersect_key($fields, $this->include);
		}
		
		if ($this->exclude)
		{
			return array_diff_key($fields, $this->exclude); 
		}
		
		return null;
	}
	
	/**
	 * @param array $data The entire object data
	 * @return array The new data object with mapped fields.
	 */
	public function mapFields(array $data)
	{
		if (!$this->variations) return $data;
		
		foreach ($data as $field => $value)
		{
			if (!isset($this->variations[$field])) continue;
			
			$data[$this->variations[$field]] = $value;
			unset($data[$field]);
		}
		
		return $data;
	}
	
	
	/**
	 * @param array|string $fields
	 * @return static
	 */
	public function includeOnly($fields)
	{
		if (!is_array($fields))
		{
			$this->include[$fields] = true;
		}
		else
		{
			$this->include += array_flip($fields);
		}
		
		return $this;
	}
	
	/**
	 * @param array|string $fields
	 * @return static
	 */
	public function excludeAny($fields)
	{
		if (!is_array($fields))
		{
			$this->exclude[$fields] = true;
		}
		else
		{
			$this->exclude += array_flip($fields);
		}
		
		return $this;
	}
	
	/**
	 * @param string $dataName
	 * @param string $objectName
	 * @return static
	 */
	public function mapDataField($dataName, $objectName)
	{
		$this->variations[$dataName] = $objectName;
		return $this;
	}
	
	/**
	 * @param string $objectName
	 * @param string $variations
	 * @return static
	 */
	public function fieldVariations($objectName, $variations)
	{
		if (!is_array($variations)) return $this->mapDataField($variations, $objectName);
		
		foreach ($variations as $variation)
		{
			$this->variations[$variation] = $objectName;
		}
		
		return $this;
	}
}