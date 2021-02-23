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
    /**
     * @var \SimpleXMLElement
     */
    protected $xml;

    /**
     * Array of XML namespaces found in document
     *
     * @var array
     */
    protected $namespaces;

    /**
     * Constructor
     *
     * @param \SimpleXMLElement|string $data
     * @param \Lurn\EPub\Resource\ZipFileResource $resource
     * @throws \Lurn\EPub\Exception\InvalidArgumentException
     */
    public function __construct($data, ZipFileResource $resource = null)
    {
        if (! is_string($data) && ! $data instanceof SimpleEXMLElement) {
            throw new InvalidArgumentException('Invalid data type for OpfResource');
        }

        $this->xml = is_string($data) ? new SimpleXMLElement($data) : $data;

        $this->resource = $resource;

        $this->namespaces = $this->xml->getNamespaces(true);
    }

    public static function make(
        $data,
        ?ZipFileResource $resource = null,
        ?Package $package = null
    ) {
        return (new static($data, $resource))->bind($package);
    }

    /**
     * Processes the XML data and puts the data into a Package object
     *
     * @param Package $package
     *
     * @return Package
     */
    public function bind(?Package $package = null)
    {
        $package ??= new Package();
        $xml = $this->xml;

        $package->version = (string) $xml['version'];

        $this->processMetadataElement($xml->metadata, $package->metadata);
        $this->processManifestElement($xml->manifest, $package->manifest);
        $this->processSpineElement($xml->spine, $package->spine, $package->manifest, $package->navigation);

        if ($xml->guide) {
            $this->processGuideElement($xml->guide, $package->guide);
        }

        return $package;
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
        foreach ($xml->item as $child) {
            $item = new ManifestItem();

            $item->id       = (string) $child['id'];
            $item->href     = (string) $child['href'];
            $item->type     = (string) $child['media-type'];
            $item->fallback = (string) $child['fallback'];

            $this->addContentGetter($item);

            $manifest->add($item);
        }
    }

    protected function processSpineElement(
        SimpleXMLElement $xml,
        Spine $spine,
        Manifest $manifest,
        Navigation $navigation
    ) {
        $position = 1;
        foreach ($xml->itemref as $child) {
            $id = (string) $child['idref'];
            $manifestItem = $manifest->get($id);

            if (! $linear = $child['linear']) {
                $linear = 'yes';
            }

            $item = new SpineItem();

            $item->id     = $id;
            $item->type   = $manifestItem->type;
            $item->href   = $manifestItem->href;
            $item->order  = $position;
            $item->linear = $linear;

            $this->addContentGetter($item);

            $spine->add($item);

            $position++;
        }

        $ncxId = $xml['toc'] ? (string) $xml['toc'] : 'ncx';

        if ($manifest->has($ncxId)) {
            $navigation->src = $manifest->get($ncxId);
        }
    }

    protected function processGuideElement(SimpleXMLElement $xml, Guide $guide)
    {
        foreach ($xml->reference as $child) {
            $item = new GuideItem();

            $item->title = (string) $child['title'];
            $item->type  = (string) $child['type'];
            $item->href  = (string) $child['href'];

            $this->addContentGetter($item);

            $guide->add($item);
        }
    }

    /**
     * Builds an array from XML attributes
     *
     * For instance:
     *
     *   <tag
     *       xmlns:opf="http://www.idpf.org/2007/opf"
     *       opf:file-as="Some Guy"
     *       id="name"/>
     *
     * Will become:
     *
     *   array('opf:file-as' => 'Some Guy', 'id' => 'name')
     *
     * **NOTE**: Namespaced attributes will have the namespace prefix
     *           prepended to the attribute name
     *
     * @param \SimpleXMLElement $xml The XML tag to grab attributes from
     *
     * @return array
     */
    protected function getXmlAttributes($xml)
    {
        $attributes = [];

        foreach ($this->namespaces as $prefix => $namespace) {
            foreach ($xml->attributes($namespace) as $attr => $value) {
                if ($prefix !== "") {
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
            $item->setContent(fn () => $this->resource->get($item->href));
        }
    }
}
