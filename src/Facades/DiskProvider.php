<?php

namespace Apsonex\SaasUtils\Facades;

use Apsonex\SaasUtils\Utils\StorageDisks\DiskProviderContract;
use Illuminate\Support\Facades\Facade;


/**
 * @method static DiskProviderContract forEnvironment(string $environment)
 * @method static DiskProviderContract public ()
 * @method static DiskProviderContract private ()
 * @method static DiskProviderContract byVisibility(string $visibility)
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