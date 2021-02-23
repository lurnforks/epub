<?php

namespace Lurn\EPub;

use Lurn\EPub\Loader\ZipFileLoader;

class Reader
{
    protected ZipFileLoader $loader;

    public function __construct()
    {
        $this->loader = new ZipFileLoader();
    }

    public static function make(string $file)
    {
        return (new static())->load($file);
    }

    public function load($file)
    {
        return $this->loader->load($file);
    }
}
