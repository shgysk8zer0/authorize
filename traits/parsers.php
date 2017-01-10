<?php

namespace shgysk8zer0\Authorize\Traits;

use \net\authorize\api\contract\v1\TransactionResponseType\MessagesAType\MessageAType as Message;
use \net\authorize\api\contract\v1\TransactionResponseType\ErrorsAType\ErrorAType as Error;
use \net\authorize\api\contract\v1\TransactionResponseType as Transaction;

trait Parsers
{
	/**
	 * [_parseTransaction description]
	 * @param  Transaction $trans [description]
	 * @return [type]             [description]
	 */
	private function _parseTransaction(Transaction $trans)
	{
		$this->code = intval($trans->getResponseCode());
		$this->authCode = $trans->getAuthCode();
		$this->transactionID = $trans->getTransId();
		$this->messages = array_map([$this, '_getMessages'], $trans->getMessages());
		$this->errors = array_map([$this, '_getErrors'], $trans->getErrors());
	}

	/**
	 * [_getMessages description]
	 * @param  Message   $message [description]
	 * @return stdClass          [description]
	 */
	private function _getMessages(Message $message) : \stdClass
	{
		$obj = new \stdClass();
		$obj->text = $message->getDescription();
		return $obj;
	}

	/**
	 * [_getErrors description]
	 * @param  Error    $error [description]
	 * @return stdClass        [description]
	 */
	private function _getErrors(Error $error) : \stdClass
	{
		$obj = new \stdClass();
		$obj->text = $error->getErrorText();
		return $obj;
	}
}
