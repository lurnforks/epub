<?php

namespace Lurn\EPub\Tests\Resource;

use Lurn\EPub\Reader;
use Lurn\EPub\Tests\TestCase;

class NcxResourceTest extends TestCase
{
    /** @test */
    public function extractingChapterMetadataFromNcx()
    {
        $epub = Reader::make($this->fixturePath('the_velveteen_rabbit.epub'));

        $this->assertCount(5, $epub->navigation->chapters);
        $this->assertEquals("List of Illustrations", $epub->navigation->chapters[2]->title);
    }
}
