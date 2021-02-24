<?php

namespace Lurn\EPub\Definition;

use Lurn\EPub\Definition\MetadataItem;
use Lurn\EPub\Exception\InvalidArgumentException;
use Lurn\EPub\Exception\OutOfBoundsException;

class Metadata extends Collection
{
    public function add($item)
    {
        if (! $item instanceof MetadataItem) {
            throw new InvalidArgumentException(
                'Expected instance of ' . MetadataItem::class . ', got ' . get_class($item)
            );
        }

        $id = $item->getIdentifier();

        $this->items[$id] ??= [];

        $this->items[$id][] = $item;
    }

    public function getValue($id)
    {
        $item = $this->get($id);

        if (! isset($item[0]) || ! $item[0] instanceof MetadataItem) {
            throw new OutOfBoundsException(
                'No value could be found for item: ' . json_encode($id)
            );
        }

        return $item[0]->value;
    }
}
