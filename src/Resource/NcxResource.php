<?php


namespace Lurn\EPub\Resource;

use SimpleXMLElement;
use Lurn\EPub\Definition\Package;
use Lurn\EPub\Definition\Chapter;
use Lurn\EPub\Exception\InvalidArgumentException;


class NcxResource
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
     * @throws InvalidArgumentException
     */
    public function __construct($data)
    {
        if ($data instanceof SimpleXMLElement) {
            $this->xml = $data;
        } else if (is_string($data)) {
            $this->xml = new SimpleXMLElement($data);
        } else {
            throw new InvalidArgumentException(sprintf('Invalid data type for NcxResource'));
        }

        $this->namespaces = $this->xml->getNamespaces(true);
    }


    /**
     * Processes the XML data and puts the data into a Package object
     *
     * @param Package $package
     *
     * @return Package
     */
    public function bind(Package $package = null)
    {
        $package = $package ?: new Package();

        $navMap = $this->xml->navMap;

        $this->consumeNavMap($navMap, $package->navigation->chapters);

        return $package;
    }


    protected function consumeNavMap($navMap, &$chapters)
    {
        foreach ($navMap->navPoint as $navPoint) {
            $chapters[] = $this->consumeNavPoint($navPoint);
        }
    }


    protected function consumeNavPoint($navPoint)
    {
        $chapter = new Chapter((string) $navPoint->navLabel->text, $navPoint['playOrder'], (string) $navPoint->content['src']);

        foreach ($navPoint->navPoint as $child) {
            $chapter->addChild($this->consumeNavPoint($child));
        }

        return $chapter;
    }

}
