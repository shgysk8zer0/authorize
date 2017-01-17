<?php

namespace shgysk8zer0\Authorize\Abstracts;
use \shgysk8zer0\Core_API as API;
abstract class Storage implements \Iterator, \JsonSerializable
{
	use API\Traits\Magic\Set;
	use API\Traits\Magic\Get;
	use API\Traits\Magic\Call_Setter;
	use API\Traits\Magic\Iterator;
	use \shgysk8zer0\Authorize\Traits\CamelCase;
	use \shgysk8zer0\Authorize\Traits\Validate;

	const MAGIC_PROPERTY = '_storage';
	private $_storage = array();

	final public function __isset($prop)
	{
		$this->magicPropConvert($prop);
		return isset($this->{self::MAGIC_PROPERTY}[$prop]);
	}

	final protected function _setData(Array $props = array())
	{
		array_map([$this, '__set'], array_keys($props), array_values($props));
	}

	final public function __debugInfo()
	{
		return $this->{self::MAGIC_PROPERTY};
	}

	final public function jsonSerialize()
	{
		return $this->{self::MAGIC_PROPERTY};
	}
}
