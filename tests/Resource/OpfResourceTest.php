<?php

namespace Lurn\EPub\Tests\Resource;

use Lurn\EPub\Tests\BaseTest;
use Lurn\EPub\Resource\OpfResource;
use Lurn\EPub\Definition\Metadata;
use Lurn\EPub\Definition\Manifest;

class OpfResourceTest extends BaseTest
{
    public function testLoadingValidOpenPackagingFormatFile()
    {
        $fixture = $this->getFixture('basic/OEPS/content.opf');

        $opf = new OpfResource($fixture);

        $package = $opf->bind();

        $metadata = $package->getMetadata();
        $this->assertTrue($metadata instanceof Metadata);
        $this->assertTrue($metadata->has('title'));
        $this->assertEquals('Epub Format Construction Guide', $metadata->getValue('title'));

        $manifest = $package->getManifest();
        $this->assertTrue($manifest instanceof Manifest);
        $this->assertEquals(
            array("ncx", "css", "logo", "title", "contents", "intro", "part1", "part2", "part3", "part4", "specs"),
            $manifest->keys()
        );
    }

    /**
     * @expectedException \ePub\Exception\InvalidArgumentException
     */
    public function testInvalidOpenPackagingFormatInput()
    {
        new OpfResource(null);
    }
}
