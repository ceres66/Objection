<?php
namespace Objection\Exceptions;


class InvalidPropertySetupException extends LiteObjectException
{
	/**
	 * @param string $message
	 */
	public function __construct($message)
	{
		parent::__construct($message);
	}
}