<?php

namespace ePub\Writer;

use ePub\Definition\Package;
use ePub\Exception\DuplicateItemException;
use ePub\Exception\InvalidArgumentException;

class Writer
{
	private $package;

	public function __construct(Package $package)
	{
		$this->package = $package;
	}


}
