<?php

namespace ePub\Definition;

class SpineItem implements ItemInterface
{
    public $href;

    public $id;

    public $linear;

    public $order;

    public $type;

    private $content;

    public function getIdentifier()
    {
        return $this->id;
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