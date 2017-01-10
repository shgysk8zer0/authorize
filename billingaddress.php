<?php

namespace shgysk8zer0\Authorize;
use \net\authorize\api\contract\v1 as AnetAPI;

final class BillingAddress extends Abstracts\Address
{
	public function __invoke(Array $data = array())
	{
		$this->_setData($data);
		return $this->_setAddress(new AnetAPI\CustomerAddressType());
	}
}
