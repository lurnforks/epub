<?php

namespace Lurn\EPub;

use Lurn\EPub\Definition\Package;
use Lurn\EPub\Loader\ZipFileLoader;

class Reader
{
    protected ZipFileLoader $loader;

    public function __construct()
    {
        $this->loader = new ZipFileLoader();
    }

    public static function make(string $file): Package
    {
        return (new static())->load($file);
    }

    public function load(string $file): Package
    {
        return $this->loader->load($file);
    }
}
