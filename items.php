<?php

namespace shgysk8zer0\Authorize;

final class Items extends \SplObjectStorage
{
	public function addItem(Item $item)
	{
		if ($item->validate()) {
			$this->attach($item);
			return true;
		} else {
			trigger_error(sprintf(
				'Missing properties in $item given in %s: [%s]',
				__METHOD__,
				join(', ', $item->getMissing())
			));
			return false;
		}
	}

	public function addItems($items)
	{
		foreach($items as $item) {
			$this->addItem($item);
		}
	}

	public function getTotal()
	{
		$total = 0;
		foreach ($this as $item) {
			$total += $item->price;
		}
		return $total;
	}

	public function getTax()
	{
		$tax = 0;
		foreach ($this as $item) {
			if (isset($item->tax)) {
				$tax += $item->tax;
			}
		}
		return $tax;
	}
}
