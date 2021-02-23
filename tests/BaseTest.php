<?php

namespace Lurn\EPub\Tests;

use Lurn\EPub\Definition\Package;
use Lurn\EPub\Reader;
use Orchestra\Testbench\TestCase;

abstract class BaseTest extends TestCase
{
    /**
     * Locate a test fixture file
     *
     * @param string $name Partial path to fixture
     *
     * @return string
     */
    public function getFixturePath($name)
    {
        return __DIR__ . '/fixtures/' . $name;
    }

    /**
     * Locates a fixture and returns the file contents
     *
     * @param string $name Partial path to fixture
     *
     * @return string
     */
    public function getFixture($name)
    {
        return file_get_contents($this->getFixturePath($name));
    }

    public function getFixtureEpub(string $name): Package
    {
        $fixture = $this->getFixturePath($name);

        $reader = new Reader();
        $epub   = $reader->load($fixture);

        return $epub;
    }
}
