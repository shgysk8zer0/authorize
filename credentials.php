<?php
namespace shgysk8zer0\Authorize;

final class Credentials extends \ArrayObject
{
	public function __construct(
		String $app_id,
		String $app_key,
		Bool $sandbox = true
	)
	{
		parent::__construct([
			'appID' => $app_id,
			'appKey' => $app_key,
			'sandbox' => $sandbox,
		]);
	}

	public function __get(String $prop)
	{
		return $this->__isset($prop) ? $this[$prop] : null;
	}

	public function __isset(String $prop) : Bool
	{
		return array_key_exists($prop, $this);
	}

	public function __invoke()
	{
		$merchantAuthentication = new AnetAPI\MerchantAuthenticationType();
		$merchantAuthentication->setName($this['appID']);
		$merchantAuthentication->setTransactionKey($this['appKey']);
		return $merchantAuthentication;
	}
}
