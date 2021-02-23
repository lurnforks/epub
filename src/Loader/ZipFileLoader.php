<?php

namespace Lurn\EPub\Loader;

use Lurn\EPub\Definition\Package;
use Lurn\EPub\Resource\NcxResource;
use Lurn\EPub\Resource\OpfResource;
use Lurn\EPub\Resource\ZipFileResource;

class ZipFileLoader
{
    /**
     * Reads in a ePub file and builds the Package definition
     */
    public function load(string $file): Package
    {
        $resource = new ZipFileResource($file);

        $package = $resource->getXML('META-INF/container.xml');

        if (! $opfFile = (string) ($package->rootfiles->rootfile['full-path'] ?? '')) {
            $ns = $package->getNamespaces();
            foreach ($ns as $key => $value) {
                $package->registerXPathNamespace($key, $value);
                $items = $package->xpath('//' . $key . ':rootfile/@full-path');
                $opfFile = (string) $items[0]['full-path'];
            }
        }

        $data = $resource->get($opfFile);

        // all files referenced in the OPF are relative to it's directory
        if ('.' !== $dir = dirname($opfFile)) {
            $resource->setDirectory($dir);
        }

        $opfResource = new OpfResource($data, $resource);
        $package = $opfResource->bind();

        $package->opfDirectory = dirname($opfFile);

        if ($package->navigation->src->href) {
            $ncx = $resource->get($package->navigation->src->href);
            $ncxResource = new NcxResource($ncx);
            $package = $ncxResource->bind($package);
        }

        return $package;
    }
}
