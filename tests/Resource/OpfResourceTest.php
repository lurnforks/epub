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

        $package = OpfResource::make($fixture);

        $this->assertInstanceOf(Metadata::class, $package->metadata);
        $this->assertInstanceOf(Manifest::class, $package->manifest);

        $this->assertTrue($package->metadata->has('title'));

        $this->assertEquals(
            'Epub Format Construction Guide',
            $package->metadata->title,
        );

        $this->assertEquals(
            ['ncx', 'css', 'logo', 'title', 'contents', 'intro', 'part1', 'part2', 'part3', 'part4', 'specs'],
            array_keys($package->manifest->all()),
        );
    }
}
