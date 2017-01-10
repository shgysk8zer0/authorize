<?php

namespace shgysk8zer0\Authorize;
use \net\authorize\api\contract\v1 as AnetAPI;
use \net\authorize\api\controller as AnetController;
use \net\authorize\api\constants\ANetEnvironment as AuthEnv;
use \shgysk8zer0\Core\Console as Console;

final class ChargeCard extends Abstracts\Request
{
	private $_billing;
	private $_shipping;
	private $_items;

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

	public function __invoke(Items $items = null)
	{
		if (isset($items)) {
			$this->addItems($items);
		}
		$creds = $this->_creds;
		$card = $this->_card;
		// Common setup for API credentials
		$refId = 'ref' . time();
		// Create the payment data for a credit card
		$creditCard = $card();
		$paymentOne = new AnetAPI\PaymentType();
		$paymentOne->setCreditCard($card());
		// Order info
		$order = new AnetAPI\OrderType();
		$order->setInvoiceNumber("101");
		$order->setDescription("Golf Shirts");

		$transactionRequestType = new AnetAPI\TransactionRequestType();
		$transactionRequestType->setTransactionType("authCaptureTransaction");
		foreach($this->_items as $item) {
			Console::info($item);
			$lineitem = new AnetAPI\LineItemType();
			$lineitem->setItemId("Shirts");
			$lineitem->setName($item->name);
			$lineitem->setDescription($item->description);
			$lineitem->setQuantity(isset($item->quantity) ? $item->quantity : '1');
			$lineitem->setUnitPrice(floatval($item->price));
			if (isset($item->tax) and is_numeric($item->tax)) {
				$lineitem->setTaxable('Y');
				$tax =  new AnetAPI\ExtendedAmountType();
				$tax->setName("level 2 tax name");
				$tax->setAmount(floatval($item->tax));
				$tax->setDescription("level 2 tax");
				$transactionRequestType->setTax($tax);
			} else {
				$lineitem->setTaxable('N');
			}
			$transactionRequestType->addToLineItems($lineitem);
		}
		$transactionRequestType->setAmount($this->_items->getTotal());
		// Tax info

		// Customer info
		$customer = new AnetAPI\CustomerDataType();
		$customer->setId("15");
		// PO Number
		$ponumber = "15";

		//create a transaction
		$transactionRequestType->setPayment($paymentOne);
		$transactionRequestType->setOrder($order);
		$transactionRequestType->setPoNumber($ponumber);
		$transactionRequestType->setCustomer($customer);

		if (isset($this->_billing)) {
			$billto = $this->_billing;
			$transactionRequestType->setBillTo($billto());
			$customer->setEmail($billto->email);
			unset($billto);
		} else {
			throw new \Exception(sprintf('No billing address given in %s', __CLASS__));
		}

		if (isset($this->_shipping)) {
			$shipto = $this->_shipping;
			$transactionRequestType->setShipTo($shipto());
			unset($shipto);
		}
		$request = new AnetAPI\CreateTransactionRequest();
		$request->setMerchantAuthentication($creds());
		$request->setRefId( $refId);
		$request->setTransactionRequest($transactionRequestType);
		$controller = new AnetController\CreateTransactionController($request);
		$response = $controller->executeWithApiResponse(
			$this->_creds->sandbox ? AuthEnv::SANDBOX : AuthEnv::PRODUCTION
		);

		return isset($response) ? new Response($response) : false;
	}

	public function setBillingAddress(BillingAddress $addr)
	{
		if ($addr->validate()) {
			$this->_billing = $addr;
		} else {
			throw new \InvalidArgumentException(sprintf(
				'Missing data in %s: [%s]',
				get_class($addr),
				join(', ', $addr->getMissing())
			));
		}
	}

	public function setShippingAddress(ShippingAddress $addr)
	{
		$this->_shipping = $addr;
	}
}
