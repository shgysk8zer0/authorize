<?php

namespace shgysk8zer0\Authorize;

final class CreditCard
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
		$this->name = $name;
		$this->number = $number;
		$this->expires = $expires;
		$this->csc = $csc;
	}

	public function __get($prop)
	{
		return $this->{$prop};
	}

	public function __invoke()
	{
		$creditCard = new AnetAPI\CreditCardType();
		$creditCard->setCardNumber($this->_number);
		$creditCard->setExpirationDate($this->_expires->format('Y-m'));
	}
}
