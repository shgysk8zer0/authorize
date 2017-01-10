<?php
namespace shgysk8zer0\Authorize\Abstracts;

use \net\authorize\api\contract\v1\CreateTransactionResponse as Resp;
use \net\authorize\api\contract\v1\TransactionResponseType as Transaction;
abstract class Response
{
	use \shgysk8zer0\Authorize\Traits\Parsers;
	use \shgysk8zer0\Authorize\Traits\toString;

	public $code = 0;
	public $messages = array();
	public $errors = array();
	public $authCode;
	public $transactionID;

	public function __construct(Resp $response)
	{
		$transaction = $response->getTransactionResponse();
		if (isset($transaction)) {
			$this->_parseTransaction($transaction);
		}
	}
}
