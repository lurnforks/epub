<?php

namespace Lurn\EPub\Definition;

use Illuminate\Support;

abstract class Collection extends Support\Collection
{
    public function __get($key)
    {
        if ($this->has($key)) {
            $value = $this->get($key);

            return is_array($value) ? $value[0]->value : $value;
        }

        return parent::__get($key);
    }

    public function add($item)
    {
        return $this->put($item->getIdentifier(), $item);
    }
}
