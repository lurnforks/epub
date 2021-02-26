<?php

namespace Lurn\EPub\Definition;

use Illuminate\Support\Str;
use Lurn\EPub\Definition\ItemInterface;

class ManifestItem implements ItemInterface
{
    public string $id = '';

    public string $href = '';

    public string $type = '';

    public string $fallback = '';

    public bool $isImage = false;

    protected $content;

    public static function fromXmlAttributes($attributes)
    {
        $item = new static();

        $item->id = (string) $attributes['id'];
        $item->href = (string) $attributes['href'];
        $item->type = (string) $attributes['media-type'];
        $item->fallback = (string) $attributes['fallback'];
        $item->isImage = Str::startsWith($attributes['media-type'], 'image/');

        return $item;
    }

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
        // if (is_callable($this->content)) {
        //     $func = $this->content;

        //     $this->content = $func();
        // }

        return value($this->content);
    }
}
