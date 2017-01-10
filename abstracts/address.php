<?php

namespace shgysk8zer0\Authorize\Abstracts;
use \shgysk8zer0\Core_API as API;
abstract class Address extends Storage
{
	const REQUIRED = [
		'first_name',
		'last_name',
		'address',
		'city',
		'state',
		'zip',
		'country',
	];

	public function __construct(Array $data = array())
	{
		$this->_setData($data);
	}

	final public function fromAddress(Address $addr)
	{
		if ($addr->validate()) {
			foreach ($addr as $key => $value) {
				$this->__set($key, $value);
			}
		} else {
			throw new \InvalidArgumentException(sprintf(
				'Missing properties in $item given in %s: [%s]',
				__METHOD__,
				join(', ', $addr->getMissing())
			));
		}
		return $this;
	}

	final protected function _setAddress($addr)
	{
		if ($this->validate()) {
			// $shipto = new AnetAPI\NameAndAddressType();
			$addr->setFirstName($this->first_name);
			$addr->setLastName($this->last_name);
			if (isset($this->company)) {
				$addr->setCompany($this->company);
			}
			$addr->setAddress($this->address);
			$addr->setCity($this->city);
			$addr->setState($this->state);
			$addr->setZip($this->zip);
			$addr->setCountry($this->country);
			return $addr;
		} else {
			throw new \Exception(sprintf(
				'Missing properties in %s, [%s]',
				__CLASS__,
				join(', ', $this->getMissing())
			));
		}
	}
}
