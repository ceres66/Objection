<?php
namespace Objection\TypeCompiler\Builders;


use PHPCoder\Base\Token\IToken;
use PHPCoder\Base\Build\IBuilder;
use PHPCoder\Tokens\Generic\IdentifierToken;


abstract class AbstractSetterBodyBuilder implements IBuilder
{
	/** @var IdentifierToken */
	private $instance;
	
	/** @var IdentifierToken */
	private $value;


	/**
	 * @return IdentifierToken
	 */
	public function instance()
	{
		return $this->instance;
	}

	/**
	 * @return IdentifierToken
	 */
	public function value()
	{
		return $this->value;
	}
	
	
	/**
	 * @param IToken $root
	 * @return IToken
	 */
	public abstract function build(IToken $root);
	
	/**
	 * @return IBuilder[]
	 */
	public function children()
	{
		return [];
	}
}