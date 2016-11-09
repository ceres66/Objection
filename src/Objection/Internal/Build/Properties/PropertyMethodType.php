<?php
namespace Objection\Internal\Build\Properties;


class PropertyMethodType
{
	use \Objection\TEnum;
	
	
	const ACCESSOR	= 0;
	const MUTATOR	= 1;
}