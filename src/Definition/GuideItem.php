<?php

namespace Lurn\EPub\Definition;

class GuideItem implements ItemInterface
{
    public $href;

    public $type;

    public $title;

    protected $content;

    public function getIdentifier()
    {
        return $this->type;
    }

    public function setContent($content)
    {
        $this->content = $content;
    }

    public function getContent()
    {
        return value($this->content);
    }
}
