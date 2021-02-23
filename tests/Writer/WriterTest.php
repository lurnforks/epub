<?php

namespace Lurn\EPub\Tests\Writer;

use Lurn\EPub\Tests\BaseTest;
use Lurn\EPub\Reader;
use Lurn\EPub\Resource\Dumper\OpfResourceDumper;

class WriterTest extends BaseTest
{
    public function testLoadingEpubFile()
    {
        $fixture = $this->getFixturePath('the_velveteen_rabbit.epub');

        $reader = new Reader();
        $epub = $reader->load($fixture);

        $this->assertTrue($epub instanceof \ePub\Definition\Package);

        $dumper = new OpfResourceDumper($epub);
        // This looks like a WIP, let's comment it out for now:
        // echo $dumper->dump();
    }

    public function testReadingManifestItemContent()
    {
        $fixture = $this->getFixturePath('the_velveteen_rabbit.epub');

        $reader = new Reader();
        $epub   = $reader->load($fixture);

        $manifest   = $epub->getManifest();
        $dedication = $manifest->get('dedication');
        $expected   = $this->getFixture('the-velveteen-rabbit/' . $dedication->href);
        $this->assertEquals($expected, $dedication->getContent());
    }
}
