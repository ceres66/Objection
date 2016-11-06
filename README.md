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

## Properties:

```php
/**
 * @property $ID
 */
class MyClass
{
}

$object = new MyClass();
$object->ID = 2;
echo $object->ID;
// Output: "2"
```
