<?php

namespace shgysk8zer0\Authorize\Abstracts;

abstract class Request
{
	private $_creds;
	private $_card;
	public function __construct(
		\shgysk8zer0\Authorize\Credentials $creds,
		\shgysk8zer0\Authorize\CreditCard $card
	)
	{
		$this->_creds = $creds;
		$this->_card = $card;
	}
}
