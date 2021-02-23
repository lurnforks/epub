<?php

namespace Lurn\EPub\Definition;

use Lurn\EPub\Definition\ManifestItem;

abstract class Collection
{
    protected $items;

    public function __construct()
    {
        $this->items = [];
    }

    public function add(ItemInterface $item)
    {
        $id = $item->getIdentifier();

        /* Not sure if an exception is really best here... maybe just don't overwrite data?
        if (isset($this->items[$id])) {
            throw new \RuntimeException(sprintf('Attempting to add a duplicate %s "%s"', get_class($item), $id));
        } */

        $this->items[$id] = $item;
    }

    public function has($id)
    {
        return array_key_exists($id, $this->items);
    }

    public function get($id)
    {
        return $this->items[$id];
    }

    public function keys()
    {
        return array_keys($this->items);
    }

    public function all()
    {
        return $this->items;
    }
}
