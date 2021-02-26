<?php

namespace Lurn\EPub\Resource;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Lurn\EPub\Definition\Chapter;
use Lurn\EPub\Definition\Package;
use Lurn\EPub\Exception\InvalidArgumentException;
use SimpleXMLElement;

class NcxResource
{
    protected SimpleXMLElement $xml;

    /**
     * Constructor
     *
     * @param \SimpleXMLElement|string $data
     * @throws \Lurn\EPub\Exception\InvalidArgumentException
     */
    public function __construct($data)
    {
        if (! is_string($data) && ! $data instanceof SimpleEXMLElement) {
            throw new InvalidArgumentException('Invalid data type for OpfResource');
        }

        $this->xml = is_string($data) ? new SimpleXMLElement($data) : $data;
    }

    public static function make($data, ?Package $package = null)
    {
        return (new static($data))->bind($package);
    }

    public function bind(?Package $package = null): Package
    {
        $package ??= new Package();

        $this->consumeNavMap($this->xml->navMap, $package->navigation->chapters);

        return $package;
    }

    protected function consumeNavMap($navMap, Collection $chapters)
    {
        foreach ($navMap->navPoint as $navPoint) {
            $chapters->add($this->consumeNavPoint($navPoint));
        }
    }

    protected function consumeNavPoint($navPoint)
    {
        $chapter = Chapter::fromNavPoint($navPoint);

        foreach ($navPoint->navPoint as $child) {
            $chapter->children->add($this->consumeNavPoint($child));
        }

        return $chapter;
    }
}
