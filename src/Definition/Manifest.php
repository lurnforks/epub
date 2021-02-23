<?php

namespace Lurn\EPub\Definition;

use Lurn\EPub\Definition\Metadata;
use Lurn\EPub\Definition\ManifestItem;
use Lurn\EPub\Exception\DuplicateItemException;
use Lurn\EPub\Exception\InvalidArgumentException;

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
