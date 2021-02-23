<?php

namespace Lurn\EPub\Definition;

class Chapter
{
    public $title;

    public $src;

    public $position;

    public $children;

    public function __construct($title, $pos, $src = null)
    {
        $this->title = str_replace(["\n", "\r"], ' ', $title);
        $this->src = $src;
        $this->position = (int) $pos;
        $this->children = [];
    }

    public function addChild(Chapter $child)
    {
        $this->children[] = $child;
    }
}
