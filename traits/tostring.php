<?php

namespace shgysk8zer0\Authorize\Traits;

trait toString
{
	/**
	 * [__toString description]
	 * @return string [description]
	 */
	public function __toString() : String
	{
		if (!empty($this->messages)) {
			return $this->messages[0]->text;
		} elseif (!empty($this->errors)) {
			return $this->errors[0]->text;
		} else {
			return 'No errors or messages';
		}
	}
}
