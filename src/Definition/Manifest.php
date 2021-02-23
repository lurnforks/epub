<?php

namespace ePub\Definition;

use ePub\Definition\Metadata;
use ePub\Definition\ManifestItem;
use ePub\Exception\DuplicateItemException;
use ePub\Exception\InvalidArgumentException;

class Manifest extends Collection
{
    /**
     * @var array
     */
    private $resources = array();

    /**
     * {@inheritDoc}
     */
    public function add(ItemInterface $item)
    {
        if (!($item instanceof ManifestItem)) {
            throw new InvalidArgumentException(sprintf(
                'Expected instance of ePub\Definition\ManifestItem, got %s',
                get_class($item)
            ));
        }

        $id = $item->getIdentifier();

        $href = $item->href;

        if (isset($this->resources[$href])) {
            throw new DuplicateItemException(
                'A single resource (href) must not be listed in the manifest more than once'
            );
        }

        $this->resources[$href] = $item;
        $this->items[$id]       = $item;
    }
}
