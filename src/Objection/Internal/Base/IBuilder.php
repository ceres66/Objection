<?php
namespace Objection\Internal\Base;


use Objection\Internal\Build\Base\IDynamicConfig;
use Objection\Internal\Build\Base\IBuildConfiguration;


interface IBuilder
{
	/**
	 * @return static
	 */
	public function useDefaultConfig();
	
	/**
	 * @param IBuildConfiguration $configuration
	 * @return static
	 */
	public function useConfig(IBuildConfiguration $configuration);

	/**
	 * @return IDynamicConfig
	 */
	public function config();
}