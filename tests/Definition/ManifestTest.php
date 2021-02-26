<?php

namespace Lurn\EPub\Tests\Definition;

use Lurn\EPub\Exception\InvalidArgumentException;
use Lurn\EPub\Reader;
use Lurn\EPub\Tests\TestCase;

class ManifestTest extends TestCase
{
    /** @test */
    public function manifestThrowsExceptionWhenIncorrectTypeIsGiven()
    {
        $this->expectException(InvalidArgumentException::class);

        $epub = Reader::make($this->fixturePath('the_velveteen_rabbit.epub'));
        $epub->manifest->add('test');
    }

    /** @test */
    public function imagesCanBeExtractedFromTheManifest()
    {
        $epub = Reader::make($this->fixturePath('the_velveteen_rabbit.epub'));

        $this->assertCount(8, $epub->manifest->images());
    }

    /** @test */
    public function documentsCanBeExtractedFromTheManifest()
    {
        $epub = Reader::make($this->fixturePath('the_velveteen_rabbit.epub'));

        $this->assertCount(5, $epub->manifest->documents());
    }
}
