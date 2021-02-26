<?php

namespace Lurn\EPub\Loader;

use Lurn\EPub\Definition\Package;
use Lurn\EPub\Resource\NcxResource;
use Lurn\EPub\Resource\OpfResource;
use Lurn\EPub\Resource\ZipFileResource;

class ZipFileLoader
{
    protected ZipFileResource $resource;

    public function load(string $file): Package
    {
        $this->resource = new ZipFileResource($file);

        $container = $this->resource->extractXml('META-INF/container.xml');

        $opfFile = (string) ($container->rootfiles->rootfile['full-path'] ?? $this->getOpfFromNamespaces($container));

        return $this->getPackageFromOpf($opfFile);
    }

    protected function getOpfFromNamespaces($package)
    {
        $opf = '';

        foreach ($package->getNamespaces() as $key => $value) {
            $package->registerXPathNamespace($key, $value);
            $items = $package->xpath("//{$key}:rootfile/@full-path");
            $opf = (string) $items[0]['full-path'];
        }

        return $opf;
    }

    protected function getPackageFromOpf($opf): Package
    {
        $data = $this->resource->extract($opf);

        // All files referenced in the OPF are relative to it's directory.
        if ('.' !== $dir = dirname($opf)) {
            $this->resource->setDirectory($dir);
        }

        $package = OpfResource::make($data, $this->resource);

        $package->opfDirectory = dirname($opf);

        if ($package->navigation->src->href) {
            $package = NcxResource::make(
                $this->resource->extract($package->navigation->src->href),
                $package,
            );
        }

        return $package;
    }
}
