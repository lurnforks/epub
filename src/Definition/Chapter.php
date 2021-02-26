<?php

namespace Lurn\EPub\Definition;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Spatie\DataTransferObject\DataTransferObject;

class Chapter extends DataTransferObject
{
    public ?string $title;

    public ?string $src;

    public ?int $position;

    public bool $isSubsection = false;

    public ?Collection $children;

    public static function fromNavPoint($navPoint)
    {
        $chapter = new static();

        $chapter->title = str_replace(["\n", "\r"], ' ', $navPoint->navLabel->text);
        $chapter->src = $navPoint->content['src'];
        $chapter->position = (int) $navPoint->playOrder;
        $chapter->children = Collection::make();
        $chapter->isSubsection = Str::contains($navPoint->content['src'], '#');

        return $chapter;
    }
}
