<?php

namespace ePub\Definition;

class GuideItem implements ItemInterface
{
    public $href;

    public $type;

    public $title;

    private $content;

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
        if (is_callable($this->content)) {
            $func = $this->content;

            $this->content = $func();
        }

        return $this->content;
    }
}