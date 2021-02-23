<?php

namespace ePub\Definition;

use ePub\Definition\ManifestItem;

class Package
{
    public $version;

    public $opfDirectory;

    public $metadata;

    public $manifest;

    public $spine;

    public $guide;

    public $navigation;

    public function __construct()
    {
        $this->manifest   = new Manifest();
        $this->metadata   = new Metadata();
        $this->spine      = new Spine();
        $this->guide      = new Guide();
        $this->navigation = new Navigation();
    }

    public function getMetadata()
    {
        return $this->metadata;
    }

    public function getManifest()
    {
        return $this->manifest;
    }

    public function getSpine()
    {
        return $this->spine;
    }

    public function getGuide()
    {
        return $this->guide;
    }

    public function getNavigation()
    {
        return $this->navigation;
    }
}
