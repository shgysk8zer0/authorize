<?php
namespace shgysk8zer0\Authorize\Traits;

trait Validate
{
	final public function validate()
	{
		$valid = true;
		foreach ($this::REQUIRED as $prop) {
			if (! $this->__isset($prop)) {
				$valid = false;
				break;
			}
		}
		return $valid;
	}

	final public function getMissing()
	{
		$missing = array_diff(
			$this::REQUIRED,
			array_keys(array_filter($this->{self::MAGIC_PROPERTY}))
		);
		return array_values($missing);
	}
}
