<?php

namespace Lurn\EPub\Tests\Definition;

use Lurn\EPub\Exception\InvalidArgumentException;
use Lurn\EPub\Reader;
use Lurn\EPub\Tests\TestCase;

class MetadataTest extends TestCase
{
    /** @test */
    public function metadataThrowsExceptionWhenIncorrectTypeIsGiven()
    {
        $this->expectException(InvalidArgumentException::class);

        $epub = Reader::make($this->fixturePath('the_velveteen_rabbit.epub'));
        $epub->metadata->add('test');
    }
}
