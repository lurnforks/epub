<?php

namespace Lurn\EPub\Tests\Resource;

use Lurn\EPub\Tests\BaseTest;

class NcxResourceTest extends BaseTest
{
    public function testExtractingChaptersFromNcx()
    {
        $epub = $this->getFixtureEpub('the_velveteen_rabbit.epub');

        $this->assertCount(5, $epub->navigation->chapters);
        $this->assertEquals("List of Illustrations", $epub->navigation->chapters[2]->title);
    }

}
