<?php

namespace Lurn\EPub\Definition;

use Lurn\EPub\Resource\ZipFileResource;

class Package
{
    public string $version = '';

    public string $opfDirectory = '';

    public Metadata $metadata;

    public Manifest $manifest;

    public Spine $spine;

    public Guide $guide;

    public Navigation $navigation;

    public ?ZipFileResource $resource;

    public function __construct()
    {
        $this->manifest = new Manifest();
        $this->metadata = new Metadata();
        $this->spine = new Spine();
        $this->guide = new Guide();
        $this->navigation = new Navigation();
    }

    public function setResource($resource): self
    {
        $this->resource = $resource;
        return $this;
    }

    public function setVersion(string $version): self
    {
        $this->version = $version;
        return $this;
    }
}
