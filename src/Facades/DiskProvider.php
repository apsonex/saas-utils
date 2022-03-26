<?php

namespace Apsonex\SaasUtils\Facades;

use Apsonex\SaasUtils\Utils\StorageDisks\DiskProviderContract;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Facades\Facade;


/**
 * @method static DiskProviderContract forEnvironment(string $environment)
 * @method static Filesystem public()
 * @method static Filesystem private()
 * @method static Filesystem byVisibility(string $visibility)
 */
class DiskProvider extends Facade
{

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'disk-provider';
    }

}