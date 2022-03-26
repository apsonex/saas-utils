<?php

namespace Apsonex\SaasUtils\Tests;

use Apsonex\SaasUtils\SaasUtilsServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{

    /**
     * Register service providers
     */
    protected function getPackageProviders($app): array
    {
        return [
            SaasUtilsServiceProvider::class,
        ];
    }
}