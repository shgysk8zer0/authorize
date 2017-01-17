<?php

namespace shgysk8zer0\Authorize\Traits;

trait ShippingAddr
{
	protected $_shipping;

	public function setShippingAddress(\shgysk8zer0\Authorize\Abstracts\Address $addr)
	{
		if ($addr->validate()) {
			$this->_shipping = $addr;
		} else {
			throw new \InvalidArgumentException(sprintf(
				'Missing data in %s: [%s]',
				get_class($addr),
				join(', ', $addr->getMissing())
			));
		}
	}
}
