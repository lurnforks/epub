<?php

namespace ePub\Definition;

class MetadataItem implements ItemInterface
{
    public $name;

    public $value;

    public $attributes = array();

    public function getIdentifier()
    {
        return $this->name;
    }
}
