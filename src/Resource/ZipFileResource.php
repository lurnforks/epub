<?php

namespace Lurn\EPub\Resource;

use Lurn\EPub\Exception\FileNotFoundException;
use SimpleXMLElement;
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

    public function setDirectory(string $dir)
    {
        $this->currentDir = $dir;
        return $this;
    }

    public function extract(string $name): string
    {
        if (null !== $this->currentDir) {
            $name = $this->currentDir . '/' . $name;
        }

        return $this->archive->getFromName($name);
    }

    public function extractXml(string $name): SimpleXMLElement
    {
        return simplexml_load_string($this->extract($name));
    }
}
