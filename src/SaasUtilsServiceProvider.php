<?php

namespace Apsonex\SaasUtils;

use Apsonex\SaasUtils\Utils\StorageDisks\DiskProvider;
use Apsonex\SaasUtils\Utils\StorageDisks\DiskProviderContract;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;

class SaasUtilsServiceProvider extends ServiceProvider
{

    const CONFIG_PATH = __DIR__ . '/../config/saas-utils.php';

    public function register()
    {
        $this->mergeConfigFrom(self::CONFIG_PATH, 'saas-utils');

        $this->app->bind('disk-provider', fn($app) => new DiskProvider());
    }

    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                self::CONFIG_PATH => config_path('saas-utils.php'),
            ], 'saas-utils');
        }
    }

}