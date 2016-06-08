<?php
namespace Objection\Structure;


class HashSet implements \IteratorAggregate
{
	private $set = [];
	
	
	/**
	 * @param int|string|array $keys
	 */
	public function __construct($keys = []) 
	{
		$this->add($keys);
	}
	
	
	/**
	 * @param string|int|array $key Single element or array of elements. 
	 */
	public function add($key)
	{
		if (!is_array($key))
		{
			$keys = [$key => null];
		}
		else
		{
			$keys = array_combine($key, array_fill(0, count($key), null));
		}
		
		$this->set += $keys;
	}
	
	/**
	 * @param string|int|array $key
	 */
	public function remove($key)
	{
		if (!is_array($key))
		{
			unset($this->set[$key]);
		}
		else
		{
			foreach ($key as $singleKey)
			{
				unset($this->set[$singleKey]);
			}
		}
	}
	
	/**
	 * @param string|int $key
	 * @return bool
	 */
	public function has($key)
	{
		return array_key_exists($key, $this->set);
	}
	
	/**
	 * @param array $keys
	 * @return bool
	 */
	public function hasAll(array $keys)
	{
		foreach ($keys as $key)
		{
			if (!array_key_exists($key, $this->set))
			{
				return false;
			}
		}
		
		return true;
	}
	
	/**
	 * @param array $keys
	 * @return bool
	 */
	public function hasAny(array $keys)
	{
		foreach ($keys as $key)
		{
			if (array_key_exists($key, $this->set))
			{
				return true;
			}
		}
		
		return false;
	}
	
	/**
	 * @return int
	 */
	public function count()
	{
		return count($this->set);
	}
	
	/**
	 * @return bool
	 */
	public function isEmpty()
	{
		return !((bool)$this->set);
	}
	
	/**
	 * @return array
	 */
	public function getKeys()
	{
		return array_keys($this->set);
	}
	
	/**
	 * @link http://php.net/manual/en/iteratoraggregate.getiterator.php
	 * @return \Traversable
	 */
	public function getIterator()
	{
		return new \ArrayIterator($this->getKeys());
	}
}