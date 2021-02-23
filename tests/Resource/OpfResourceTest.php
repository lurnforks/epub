<?php

namespace Lurn\EPub\Tests\Resource;

use Lurn\EPub\Definition\Manifest;
use Lurn\EPub\Definition\Metadata;
use Lurn\EPub\Resource\OpfResource;
use Lurn\EPub\Tests\TestCase;

class OpfResourceTest extends TestCase
{
    /** @test */
    public function loadingValidOpenPackagingFormatFile()
    {
        $fixture = $this->getFixtureContents('basic/OEPS/content.opf');

        $opf = new OpfResource($fixture);

        $package = $opf->bind();

        $metadata = $package->getMetadata();
        $this->assertTrue($metadata instanceof Metadata);
        $this->assertTrue($metadata->has('title'));
        $this->assertEquals('Epub Format Construction Guide', $metadata->getValue('title'));

        $manifest = $package->getManifest();
        $this->assertTrue($manifest instanceof Manifest);
        $this->assertEquals(
            ["ncx", "css", "logo", "title", "contents", "intro", "part1", "part2", "part3", "part4", "specs"],
            $manifest->keys()
        );
    }
}
