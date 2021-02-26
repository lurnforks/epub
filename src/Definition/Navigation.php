<?php

namespace Lurn\EPub\Definition;

use Illuminate\Support\Collection;
use Spatie\DataTransferObject\DataTransferObject;

class Navigation extends DataTransferObject
{
    public ManifestItem $src;

    public Collection $chapters;

    public function __construct()
    {
        $this->src = new ManifestItem();
        $this->chapters = new Collection();
    }
}
