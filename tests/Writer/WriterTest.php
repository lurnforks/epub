<?php

namespace Lurn\EPub\Tests\Writer;

use Lurn\EPub\Definition\Package;
use Lurn\EPub\Reader;
use Lurn\EPub\Resource\Dumper\OpfResourceDumper;
use Lurn\EPub\Tests\TestCase;

class WriterTest extends TestCase
{
    /** @test */
    public function loadingEpubFile()
    {
        $epub = Reader::make($this->fixturePath('the_velveteen_rabbit.epub'));

        $this->assertInstanceOf(Package::class, $epub);

        $dumper = new OpfResourceDumper($epub);
    }

    /** @test */
    public function readingManifestItemContent()
    {
        $epub = Reader::make($this->fixturePath('the_velveteen_rabbit.epub'));

        $expected = $this->getFixtureContents('the-velveteen-rabbit/' . $epub->manifest->dedication->href);

        $this->assertEquals($expected, $epub->manifest->dedication->getContent());
    }
}
