<?php
namespace shgysk8zer0\Authorize\Traits;

Trait CamelCase
{
	final private function magicPropConvert(&$prop)
	{
		$prop = strtolower($prop = preg_replace('/[A-Z]/', '_${0}', $prop));
	}
}
