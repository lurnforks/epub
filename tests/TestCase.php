<?php

namespace Lurn\EPub\Tests;

use Orchestra\Testbench\TestCase as TestCaseCase;

abstract class TestCase extends TestCaseCase
{
    public function fixturePath(string $name): string
    {
        return __DIR__ . '/fixtures/' . $name;
    }

    public function getFixtureContents(string $name): string
    {
        return file_get_contents($this->fixturePath($name));
    }
}
