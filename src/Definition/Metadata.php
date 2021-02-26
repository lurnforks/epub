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
                'Expected instance of '
                    . MetadataItem::class
                    . ', got '
                    . (is_object($item) ? get_class($item) : $item)
            );
        }

        $id = $item->getIdentifier();

        return $this->put($id, is_array($this->get($id)) ? [...$this->get($id), $item] : [$item]);
    }
}
