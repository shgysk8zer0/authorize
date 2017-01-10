<?php

namespace shgysk8zer0\Authorize\Abstracts;

abstract class Request
{
	protected $_creds;
	protected $_card;

	final public function __construct(
		\shgysk8zer0\Authorize\Credentials $creds,
		\shgysk8zer0\Authorize\CreditCard $card
	)
	{
		$this->_creds = $creds;
		$this->_card = $card;
	}
}
