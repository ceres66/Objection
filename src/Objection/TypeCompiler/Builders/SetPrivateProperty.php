<?php
namespace Objection\TypeCompiler\Builders;


use PHPCoder\Base\Token\IToken;
use PHPCoder\Base\Build\IBuilder;
use PHPCoder\Tokens\FunctionCall\ThisFunctionCallToken;


class SetPrivateProperty extends AbstractSetterBodyBuilder
{
	private $dataMember;


	/**
	 * @param string $dataMember
	 */
	public function __construct($dataMember)
	{
		$this->dataMember = $dataMember;
	}


	/**
	 * @param IToken $root
	 * @return IToken
	 */
	public function build(IToken $root)
	{
		$call = new ThisFunctionCallToken(
			'set',
			$this->instance(),
			$this->dataMember,
			$this->value());
		
		return $call->setRoot($root);
	}
	

	/**
	 * @return IBuilder[]
	 */
	public function children()
	{
		// TODO: Implement children() method.
	}
}