<?php

namespace Lurn\EPub\Definition;

use Lurn\EPub\Definition\ItemInterface;

class ManifestItem implements ItemInterface
{
    public $id;

    public $href;

    public $type;

    public $fallback;

    protected $content;

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
