<?php

namespace Lurn\EPub\Resource;

use Illuminate\Support\Collection;
use ZipArchive;

class ZipFileResource
{
    protected $archive;

    protected $currentDir;

    public function __construct($file)
    {
        $this->archive = new ZipArchive();

        $this->archive->open($file);
    }

    public function setDirectory($dir)
    {
        $this->currentDir = $dir;
    }

    public function get($name)
    {
        if (null !== $this->currentDir) {
            $name = $this->currentDir . '/' . $name;
        }

        return $this->archive->getFromName($name);
    }

    public function getXML($name)
    {
        return simplexml_load_string($this->get($name));
    }
}
