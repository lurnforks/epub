<?php

namespace Lurn\EPub\Definition;

use Lurn\EPub\Definition\Chapter;

class Navigation
{
    public $src;

    /**
     * Array of Chapters
     *
     * @var array
     */
    public $chapters;

    public function __construct()
    {
        $this->src = new ManifestItem();
        $this->chapters = [];
    }
}
