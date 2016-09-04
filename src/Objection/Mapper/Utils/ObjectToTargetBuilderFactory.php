<?php
namespace Objection\Mapper\Utils;


class ObjectToTargetBuilderFactory
{
	use \Objection\TStaticClass;
	
	
	/**
	 * @return TargetBuilders\ArrayTargetBuilder
	 */
	public static function toArrayBuilder()
	{
		return new TargetBuilders\ArrayTargetBuilder();
	}
	
	/**
	 * @return TargetBuilders\StdClassTargetBuilder
	 */
	public static function toStdClassBuilder()
	{
		return new TargetBuilders\StdClassTargetBuilder();
	}
}