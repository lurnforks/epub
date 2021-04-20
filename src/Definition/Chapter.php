<?php

namespace Lurn\EPub\Definition;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Spatie\DataTransferObject\DataTransferObject;

class Chapter extends DataTransferObject
{
    public ?string $title;

    public ?string $src;

    public ?string $href;

    public int $position = 0;

    public ?Collection $children;

    public static function fromNavPoint($navPoint)
    {
        $chapter = new static();

        $chapter->title = str_replace(["\n", "\r"], ' ', $navPoint->navLabel->text);
        $chapter->href = Str::before($navPoint->content['src'], '#');
        $chapter->src = $navPoint->content['src'];
        $chapter->position = (string) $navPoint['playOrder'];
        $chapter->children = Collection::make();

        return $chapter;
    }
}
