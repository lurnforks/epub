<?php

namespace Lurn\EPub\Resource;

use Lurn\EPub\Definition\Guide;
use Lurn\EPub\Definition\GuideItem;
use Lurn\EPub\Definition\Manifest;
use Lurn\EPub\Definition\ManifestItem;
use Lurn\EPub\Definition\Metadata;
use Lurn\EPub\Definition\MetadataItem;
use Lurn\EPub\Definition\Navigation;
use Lurn\EPub\Definition\Package;
use Lurn\EPub\Definition\Spine;
use Lurn\EPub\Definition\SpineItem;
use Lurn\EPub\Exception\InvalidArgumentException;
use Lurn\EPub\NamespaceRegistry;
use SimpleXMLElement;

class OpfResource
{
    protected SimpleXMLElement $xml;

    protected ?ZipFileResource $resource;

    /**
     * Constructor
     *
     * @param \SimpleXMLElement|string $data
     * @param \Lurn\EPub\Resource\ZipFileResource $resource
     * @throws \Lurn\EPub\Exception\InvalidArgumentException
     */
    public function __construct($data, ZipFileResource $resource = null)
    {
        if (! is_string($data) && ! $data instanceof SimpleXMLElement) {
            throw new InvalidArgumentException('Invalid data type for OpfResource');
        }

        $this->xml = is_string($data) ? new SimpleXMLElement($data) : $data;

        $this->resource = $resource;
    }

    public static function make($data, ?ZipFileResource $resource = null, ?Package $package = null)
    {
        return (new static($data, $resource))->bind($package);
    }

    public function bind(?Package $package = null): Package
    {
        $package ??= new Package();

        $package->version = (string) $this->xml['version'];

        $this->processMetadataElement($this->xml->metadata, $package->metadata);
        $this->processManifestElement($this->xml->manifest, $package->manifest);
        $this->processSpineElement($this->xml->spine, $package);

        if ($this->xml->guide) {
            $this->processGuideElement($this->xml->guide, $package->guide);
        }

        return $package
            ->setResource($this->resource)
            ->setVersion($this->xml['version']);
    }

    protected function processMetadataElement(SimpleXMLElement $xml, Metadata $metadata)
    {
        foreach ($xml->children(NamespaceRegistry::NAMESPACE_DC) as $child) {
            $item = new MetadataItem();

            $item->name = $child->getName();
            $item->value = trim((string) $child);
            $item->attributes = $this->getXmlAttributes($child);

            $metadata->add($item);
        }
    }

    protected function processManifestElement(SimpleXmlElement $xml, Manifest $manifest)
    {
        foreach ($xml->item as $attributes) {
            $item = ManifestItem::fromXmlAttributes($attributes);

            $manifest->add($item);

            $this->addContentGetter($item);
        }
    }

    protected function processSpineElement(SimpleXMLElement $xml, Package $package)
    {
        $position = 1;

        foreach ($xml->itemref as $attributes) {
            $id = (string) $attributes['idref'];
            $manifestItem = $package->manifest->get($id);

            $item = new SpineItem();

            $item->id = $id;
            $item->type = $manifestItem->type;
            $item->href = $manifestItem->href;
            $item->order = $position;
            $item->linear = $attributes['linear'] ?: 'yes';

            $this->addContentGetter($item);

            $package->spine->add($item);

            $position++;
        }

        $ncxId = $xml['toc'] ? (string) $xml['toc'] : 'ncx';

        if ($package->manifest->has($ncxId)) {
            $package->navigation->src = $package->manifest->get($ncxId);
        }
    }

    protected function processGuideElement(SimpleXMLElement $xml, Guide $guide)
    {
        foreach ($xml->reference as $attributes) {
            $item = new GuideItem();

            $item->title = (string) $attributes['title'];
            $item->type  = (string) $attributes['type'];
            $item->href  = (string) $attributes['href'];

            $this->addContentGetter($item);

            $guide->add($item);
        }
    }

    /**
     * Builds an array from XML attributes
     *
     * For instance:
     *    <tag xmlns:opf="http://www.idpf.org/2007/opf" opf:file-as="Some Guy" id="name"/>
     *
     * Will become:
     *    ['opf:file-as' => 'Some Guy', 'id' => 'name']
     *
     * Note: Namespaced attributes will have the namespace prefix
     * prepended to the attribute name
     *
     * @param \SimpleXMLElement $xml
     * @return array
     */
    protected function getXmlAttributes($element)
    {
        $attributes = [];

        foreach ($this->xml->getNamespaces(true) as $prefix => $namespace) {
            foreach ($element->attributes($namespace) as $attr => $value) {
                if ($prefix !== '') {
                    $attr = "{$prefix}:{$attr}";
                }

                $attributes[$attr] = $value;
            }
        }

        return $attributes;
    }

    protected function addContentGetter($item)
    {
        if (null !== $this->resource) {
            $item->setContent(fn () => $this->resource->extract($item->href));
        }
    }
}
