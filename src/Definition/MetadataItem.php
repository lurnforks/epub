<?php

namespace Lurn\EPub\Definition;

class MetadataItem implements ItemInterface
{
    public $name;

    public $value;

    public $attributes = [];

    public function getIdentifier()
    {
        return $this->name;
    }
}
