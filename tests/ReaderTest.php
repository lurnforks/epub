<?php

namespace Lurn\EPub\Tests;

use Lurn\EPub\Definition\Package;
use Lurn\EPub\Reader;
use Lurn\EPub\Tests\TestCase;

class ReaderTest extends TestCase
{
    /** @test */
    public function aValidEpubFileIsReadable()
    {
        $epub = Reader::make($this->fixturePath('test.epub'));

        $this->assertInstanceOf(Package::class, $epub);
    }

    /** @test */
    public function manifestItemsHaveTheCorrectContent()
    {
        $epub = Reader::make($this->fixturePath('the_velveteen_rabbit.epub'));

        $expected = $this->getFixtureContents('the-velveteen-rabbit/' . $epub->manifest->dedication->href);

        $this->assertEquals($expected, $epub->manifest->dedication->getContent());
    }

    /** @test */
    public function theEpubVersionIsSetCorrectly()
    {
        $epub = Reader::make($this->fixturePath('epub3_nested_nav.epub'));
        $this->assertEquals('3.0', $epub->version);

        $epub = Reader::make($this->fixturePath('the_velveteen_rabbit.epub'));
        $this->assertEquals('2.0', $epub->version);
    }

    /** @test */
    public function theOpfCanBeReadCorrectly()
    {
        $epub = Reader::make($this->fixturePath('the_velveteen_rabbit.epub'));
        $this->assertEquals('.', $epub->opfDirectory);

        $epub = Reader::make($this->fixturePath('epub3_nested_nav.epub'));
        $this->assertEquals('EPUB', $epub->opfDirectory);
    }

    /** @test */
    public function namespacedContainersLoadCorrectly()
    {
        $epub = Reader::make($this->fixturePath('pg19132.epub'));

        $this->assertInstanceOf(Package::class, $epub);
    }
}
