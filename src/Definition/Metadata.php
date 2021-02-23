<?php

namespace Lurn\EPub\Definition;

use Lurn\EPub\Definition\MetadataItem;
use Lurn\EPub\Exception\InvalidArgumentException;
use Lurn\EPub\Exception\OutOfBoundsException;

class Metadata extends Collection
{
    public function add(ItemInterface $item)
    {
        if (!($item instanceof MetadataItem)) {
            throw new InvalidArgumentException(sprintf(
                'Expected instance of ePub\Definition\MetadataItem, got %s',
                get_class($item)
            ));
        }

        $id = $item->getIdentifier();

        if (!isset($this->items[$id])) {
            $this->items[$id] = array();
        }

        $this->items[$id][] = $item;
    }

    public function getValue($id)
    {
        $item = $this->get($id);

        if (isset($item[0]) && $item[0] instanceof MetadataItem) {
            return $item[0]->value;
        }

        throw new OutOfBoundsException(
            "No value could be found for item: " . json_encode($id)
        );
    }
}
