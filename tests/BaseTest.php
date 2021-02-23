<?php

namespace Lurn\EPub\Tests;

use Lurn\EPub\Reader;

abstract class BaseTest extends \PHPUnit_Framework_TestCase
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

    /**
     * Locates a fixture and returns the Package
     *
     * @param string $name Partial path to fixture
     *
     * @return Package
     */
    public function getFixtureEpub($name)
    {
        $fixture = $this->getFixturePath($name);

        $reader = new Reader();
        $epub   = $reader->load($fixture);

        return $epub;
    }
}