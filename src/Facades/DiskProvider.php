<?php

namespace Apsonex\SaasUtils\Facades;

use Apsonex\SaasUtils\Utils\StorageDisks\DiskProviderContract;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Facades\Facade;


/**
 * @method static DiskProviderContract forEnvironment(string $environment)
 * @method static Filesystem default()
 * @method static string defaultDiskName()
 * @method static Filesystem public()
 * @method static string publicDiskName()
 * @method static Filesystem private()
 * @method static string privateDiskName()
 * @method static Filesystem byVisibility(string $visibility)
 * @method static string byVisibilityDiskName(string $visibility)
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
        return DiskProviderContract::class;
    }

}