<?php

namespace shgysk8zer0\Authorize;

use \net\authorize\api\contract\v1 as AnetAPI;

final class CreditCard extends \ArrayObject implements \JsonSerializable
{
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

	public function jsonSerialize()
	{
		$info = $this->getArrayCopy();
		if (array_key_exists('number', $info)) {
			$info['number'] = preg_replace('/^\d{9}/', '*********', $info['number']);
		}
		if (array_key_exists('expires', $info)) {
			$info['expires'] = $info['expires']->format('Y-m');
		}
		return $info;
	}

	public function __debugInfo()
	{
		$info = $this->getArrayCopy();
		if (array_key_exists('number', $info)) {
			$info['number'] = preg_replace('/^\d{9}/', '*********', $info['number']);
		}
		if (array_key_exists('expires', $info)) {
			$info['expires'] = $info['expires']->format('Y-m');
		}
		return $info;
	}

	public function __invoke()
	{
		$creditCard = new AnetAPI\CreditCardType();
		$creditCard->setCardNumber($this['number']);
		$creditCard->setExpirationDate($this['expires']->format('Y-m'));
		return $creditCard;
	}
}
