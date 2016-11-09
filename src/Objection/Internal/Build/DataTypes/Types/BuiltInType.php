<?php
namespace Objection\Internal\Build\DataTypes\Types;


use Objection\Internal\Build\DataTypes\Base\AbstractDataType;


class BuiltInType extends AbstractDataType
{
	/**
	 * @param string $name
	 */
	public function __construct($name)
	{
		parent::__construct(true, false, $name);
	}
	
	
	/**
	 * @param string $type
	 * @return BuiltInType
	 */
	public static function create($type)
	{
		if (!method_exists(self::class, $type))
			throw new \Exception("Unknown built in type $type");
		
		return BuiltInType::$type();
	}
	

	/**
	 * @return BuiltInType
	 */
	public static function string()
	{
		return new BuiltInType('string');
	}
	
	/**
	 * @return BuiltInType
	 */
	public static function integer()
	{
		return new BuiltInType('integer');
	}
	
	/**
	 * @return BuiltInType
	 */
	public static function double()
	{
		return new BuiltInType('double');
	}
	
	/**
	 * @return BuiltInType
	 */
	public static function boolean()
	{
		return new BuiltInType('boolean');
	}
}