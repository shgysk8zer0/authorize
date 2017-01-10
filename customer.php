<?php

namespace shgysk8zer0\Authorize;

use \shgysk8zer0\Core_API as API;
final class Customer
{
	use API\Magic\Set;
	use API\Magic\Get;
	use API\Magic\Call_Setter;

	const MAGIC_PROPERTY = '_data';

	private $_data = [
		'name' => null,
		''
	];

	public function __construct(Array $data = array())
	{
		array_map([$this, '__set', array_keys($data), array_values($data)]);
	}

	public function __isset($prop)
	{
		return isset($this->{self::MAGIC_PROPERTY}[$prop]);
	}
}
