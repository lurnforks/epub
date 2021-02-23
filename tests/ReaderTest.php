<?php

namespace Lurn\EPub\Tests;

use Lurn\EPub\Definition\Package;
use Lurn\EPub\Reader;
use Lurn\EPub\Tests\TestCase;

class ReaderTest extends TestCase
{
    /** @test */
    public function readingEpubFile()
    {
        $epub = Reader::make($this->fixturePath('the_velveteen_rabbit.epub'));

        $this->assertInstanceOf(Package::class, $epub);
    }

    /** @test */
    public function readingManifestItemContent()
    {
        $epub = Reader::make($this->fixturePath('the_velveteen_rabbit.epub'));

        $manifest   = $epub->getManifest();
        $dedication = $manifest->get('dedication');
        $expected   = $this->getFixtureContents('the-velveteen-rabbit/' . $dedication->href);
        $this->assertEquals($expected, $dedication->getContent());
    }

    /** @test */
    public function readingEpubVersion()
    {
        $epub = Reader::make($this->fixturePath('epub3_nested_nav.epub'));
        $this->assertEquals('3.0', $epub->version);

        $epub = Reader::make($this->fixturePath('the_velveteen_rabbit.epub'));
        $this->assertEquals('2.0', $epub->version);
    }

    /** @test */
    public function readingOpfDirectory()
    {
        $epub = Reader::make($this->fixturePath('the_velveteen_rabbit.epub'));
        $this->assertEquals('.', $epub->opfDirectory);

        $epub = Reader::make($this->fixturePath('epub3_nested_nav.epub'));
        $this->assertEquals('EPUB', $epub->opfDirectory);
    }

    /** @test */
    public function loadingNamespacedContainer()
    {
        $epub = Reader::make($this->fixturePath('pg19132.epub'));

        $this->assertInstanceOf(Package::class, $epub);
    }
}
