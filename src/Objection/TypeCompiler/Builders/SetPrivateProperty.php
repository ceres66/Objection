<?php
/**
 * Created by PhpStorm.
 * User: namp
 * Date: 10/22/16
 * Time: 6:27 PM
 */

namespace Objection\TypeCompiler\Builders;


use PHPCoder\Base\Build\IBuilder;
use PHPCoder\Base\Token\IToken;
use PHPCoder\Tokens\ThisMethodCallToken;
use PHPCoder\Tokens\VariableReferenceToken;


class SetPrivateProperty implements IBuilder
{
	/**
	 * @param IToken $root
	 * @return IToken
	 */
	public function build(IToken $root)
	{
		$call = new ThisMethodCallToken('set');
		$call->setRoot($root)
		$call
			->addParameter(new Self('instance'))
			->addParameter(new VariableReferenceToken('name'));
		return $call;
	}
	

	/**
	 * @return IBuilder[]
	 */
	public function children()
	{
		// TODO: Implement children() method.
	}
}