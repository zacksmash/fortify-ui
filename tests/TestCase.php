<?php

namespace Zacksmash\FortifyUI\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use Zacksmash\FortifyUI\FortifyUIServiceProvider;

class TestCase extends Orchestra
{
    public function setUp(): void
    {
        parent::setUp();
    }

    protected function getPackageProviders($app)
    {
        return [
            FortifyUIServiceProvider::class,
        ];
    }
}
