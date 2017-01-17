<?php

namespace shgysk8zer0\Authorize\Abstracts;
use \shgysk8zer0\Authorize\Item as Item;
use \shgysk8zer0\Authorize\Items as Items;
abstract class Request implements \JsonSerializable
{
	protected $_creds;
	protected $_card;
	protected $_items;

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

	public function jsonSerialize()
	{
		return [
			'Environment' => $this->_creds->sandbox ? 'Sandbox' : 'Production',
			'Items' => $this->_items,
			'CreditCard' => $this->_card,
		];
	}

	public function __debugInfo()
	{
		return [
			'Environment' => $this->_creds->sandbox ? 'Sandbox' : 'Production',
			'Items' => $this->_items,
			'CreditCard' => $this->_card,
		];
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

	public function addItem(Item $item)
	{
		if (is_null($this->_items)) {
			$this->_items = new Items;
		}
		return $this->_items->addItem($item);
	}

	public function addItems(Items $items)
	{
		foreach ($items as $item) {
			$this->addItem($item);
		}
	}

	public function getItems()
	{
		return $this->_items;
	}
}
