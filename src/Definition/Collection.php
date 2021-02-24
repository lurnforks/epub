<?php

namespace Lurn\EPub\Definition;

abstract class Collection
{
    protected array $items;

    public function __construct()
    {
        $this->items = [];
    }

    public function __get(string $property)
    {
        if ($this->has($property)) {
            $value = $this->get($property);

            return is_array($value) ? $value[0]->value : $value;
        }

        return null;
    }

    public function add(ItemInterface $item)
    {
        $this->items[$item->getIdentifier()] = $item;
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
