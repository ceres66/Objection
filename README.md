# Objection

## Installation

```shell
composer require oktopost/objection
```
or inside *composer.json*
```json
"require": {
	"oktopost/objection": "^2.0"
}
```

## Properties Definition:

```php

// Using class comment
/**
 * @property $ID
 */
class MyClassComment
{
}

// Using data member comment
class MyClassDataMember
{
	/**
	 * @Property $ID
	 */
	private $m_id
}

// Using mutator/accesser methods
class MyClassMethod
{
	/**
	 * @Property $ID
	 */
	 private function setID($id) {}
	 
	 /**
	  * @Property $ID
	  */
	 private function getID() {}
}

```

Datamember can be of any access level, but if it's name matches Property name and is accessable from the called scope, the reference will not be interapted as call to __\__get__ or __\__set__ methods and will be changed directly. For example:

```php
// INVALID definiton
class MyClass
{
	/**
	 * @Property $ID
	 */
	public $id
}

// Because PHP is case insensitive, this code will modifed the $id data member 
// directly without calling objection's handlers.
$a = new MyClass();
$a->ID = "Somthing invalid"
```
