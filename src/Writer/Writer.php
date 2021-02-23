<?php

namespace Lurn\EPub\Writer;

use Lurn\EPub\Definition\Package;
use Lurn\EPub\Exception\DuplicateItemException;
use Lurn\EPub\Exception\InvalidArgumentException;

class Writer
{
	private $package;

	public function __construct(Package $package)
	{
		$this->package = $package;
	}


}
