<?php
namespace Objection\Internal\Build\Descriptors;


class PropertyMethodType
{
	use \Objection\TEnum;
	
	
	const ACCESSOR	= 0;
	const MUTATOR	= 1;
}