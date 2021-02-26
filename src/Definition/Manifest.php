<?php

namespace Lurn\EPub\Definition;

use Illuminate\Support\Str;
use Lurn\EPub\Definition\Collection;
use Lurn\EPub\Definition\ManifestItem;
use Lurn\EPub\Exception\InvalidArgumentException;

class Manifest extends Collection
{
    public function add($item)
    {
        if (! $item instanceof ManifestItem) {
            throw new InvalidArgumentException(
                'Expected instance of '
                    . ManifestItem::class
                    . ', got '
                    . (is_object($item) ? get_class($item) : $item)
            );
        }

        return $this->put($item->getIdentifier(), $item);
    }

    public function images()
    {
        return $this->filter(fn ($item) => Str::startsWith($item->type, 'image/'));
    }

    public function documents()
    {
        return $this->filter(fn ($item) => in_array($item->type, ['text/html', 'text/xml', 'application/xhtml+xml']));
    }
}
