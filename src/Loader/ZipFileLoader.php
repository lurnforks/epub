<?php

namespace Lurn\EPub\Loader;

use Lurn\EPub\Definition\Package;
use Lurn\EPub\Resource\NcxResource;
use Lurn\EPub\Resource\OpfResource;
use Lurn\EPub\Resource\ZipFileResource;

class ZipFileLoader
{
    public function load(string $file): Package
    {
        $resource = new ZipFileResource($file);

        $package = $resource->getXML('META-INF/container.xml');

        if (! $opfFile = (string) ($package->rootfiles->rootfile['full-path'] ?? '')) {
            foreach ($package->getNamespaces() as $key => $value) {
                $package->registerXPathNamespace($key, $value);
                $items = $package->xpath("//{$key}:rootfile/@full-path");
                $opfFile = (string) $items[0]['full-path'];
            }
        }

        $data = $resource->get($opfFile);

        // All files referenced in the OPF are relative to it's directory.
        if ('.' !== $dir = dirname($opfFile)) {
            $resource->setDirectory($dir);
        }

        $package = OpfResource::make($data, $resource);

        $package->opfDirectory = dirname($opfFile);

        if ($package->navigation->src->href) {
            $package = NcxResource::make(
                $resource->get($package->navigation->src->href),
                $package,
            );
        }

        return $package;
    }
}
