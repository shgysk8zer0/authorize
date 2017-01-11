<?php

namespace shgysk8zer0\Authorize\Abstracts;

abstract class Request
{
	protected $_creds;
	protected $_card;

	private $_description = '';

	private $_invoice = 0;

	final public function __construct(
		\shgysk8zer0\Authorize\Credentials $creds,
		\shgysk8zer0\Authorize\CreditCard $card
	)
	{
		$this->_creds = $creds;
		$this->_card = $card;
		$this->setDescription("Online purchase from {$_SERVER['SERVER_NAME']}.");
	}

	final public function setInvoice(Int $invoice)
	{
		$this->_invoice = $invoice;
		return $this;
	}

	public function setDescription(String $description)
	{
		$this->_description = $description;
	}

	public function getInvoice() : Int
	{
		return $this->_invoice;
	}

	public function getDescription() : String
	{
		return $this->_description;
	}
}
