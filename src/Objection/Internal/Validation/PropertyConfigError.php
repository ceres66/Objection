<?php
namespace Objection\Internal\Validation;


use Objection\Internal\Property;

class PropertyConfigError
{
	private $propertyName;
	private $message;
	private $isFatal = false;


	/**
	 * @return string
	 */
	public function getPropertyName()
	{
		return $this->propertyName;
	}

	/**
	 * @return string
	 */
	public function getMessage()
	{
		return $this->message;
	}

	/**
	 * @return bool
	 */
	public function isFatal()
	{
		return $this->isFatal;
	}


	/**
	 * @param string|Property $property
	 * @param string $message
	 * @return PropertyConfigError
	 */
	public static function warning($property, $message)
	{
		if ($property instanceof Property)
		{
			$name = $property->getName();
		}
		else
		{
			$name = $property;
		}
		
		$error = new PropertyConfigError();
		
		$error->propertyName = $name;
		$error->message = $message;
		
		return $error;
	}

	/**
	 * @param string|Property $property
	 * @param string $message
	 * @return PropertyConfigError
	 */
	public static function fatal($property, $message)
	{
		$error = self::warning($property, $message);
		$error->isFatal = true;
		return $error;
	}
}