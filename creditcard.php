<?php

namespace shgysk8zer0\Authorize;

use \net\authorize\api\contract\v1 as AnetAPI;

final class CreditCard extends \ArrayObject
{
	private $_name;
	private $_number;
	private $_expires;
	private $_csc;

	public function __construct(
		String $name,
		Int $number,
		\DateTime $expires,
		Int $csc
	)
	{
		parent::__construct([
			'name' => $name,
			'number' => $number,
			'expires' => $expires,
			'csc' => $csc,
		]);
	}

	public function __get($prop)
	{
		return $this[$prop];
	}

	public function __isset($prop)
	{
		return array_key_exists($prop, $this);
	}

	public function __invoke()
	{
		$creditCard = new AnetAPI\CreditCardType();
		$creditCard->setCardNumber($this['number']);
		$creditCard->setExpirationDate($this['expires']->format('Y-m'));
		return $creditCard;
	}
}
