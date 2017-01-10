<?php

namespace shgysk8zer0\Authorize;

use \net\authorize\api\contract\v1 as AnetAPI;
use \net\authorize\api\controller as AnetController;
use \net\authorize\api\constants\ANetEnvironment as AuthEnv;

final class authCaptureTransaction extends Abstracts\Request
{
	const TRANSACTION_TYPE = 'authCaptureTransaction';

	public function __invoke(Float $price)
	{
		$card = $this->_card;
		$creds = $this->_creds;
		// Create the payment data for a credit card
		$paymentOne = new AnetAPI\PaymentType();
		$paymentOne->setCreditCard($card());

		// Create a transaction
		$transactionRequestType = new AnetAPI\TransactionRequestType();
		$transactionRequestType->setTransactionType(self::TRANSACTION_TYPE);
		$transactionRequestType->setAmount($price);
		$transactionRequestType->setPayment($paymentOne);

		$request = new AnetAPI\CreateTransactionRequest();
		$request->setMerchantAuthentication($creds());
		$request->setTransactionRequest($transactionRequestType);
		$controller = new AnetController\CreateTransactionController($request);
		$response = $controller->executeWithApiResponse(
			$this->_creds->sandbox ? AuthEnv::SANDBOX : AuthEnv::PRODUCTION
		);

		return isset($response) ? new Response($response) : false;
	}
}
