<?php

namespace shgysk8zer0\Authorize\Traits;

trait BillingAddr
{
	protected $_billing;

	public function setBillingAddress(\shgysk8zer0\Authorize\Abstracts\Address $addr)
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
}
