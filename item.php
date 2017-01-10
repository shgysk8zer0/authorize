<?php
namespace shgysk8zer0\Authorize;
use \shgysk8zer0\Core_API as API;
final class Item extends Abstracts\Storage
{
	const REQUIRED = [
		'price',
		'name',
		'description'
	];

	public function __construct(Array $data = array())
	{
		$this->_setData($data);
	}

	public static function create(Array $data = array())
	{
		return new self($data);
	}
}
