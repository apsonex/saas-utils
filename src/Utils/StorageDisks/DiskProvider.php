<?php

namespace Apsonex\SaasUtils\Utils\StorageDisks;

use Illuminate\Contracts\Filesystem\Filesystem;

class DiskProvider implements DiskProviderContract
{

    public function forEnvironment(string $environment): DiskProviderContract
    {
        return $this->providerInstance()->forEnvironment($environment);
    }

    public function public(): Filesystem
    {
        return $this->providerInstance()->public();
    }

    public function private(): Filesystem
    {
        return $this->providerInstance()->private();
    }

    public function byVisibility(string $visibility): Filesystem
    {
        return $this->providerInstance()->byVisibility($visibility);
    }


    protected function providerInstance(): DiskProviderContract
    {
        $class = config('saas-utils.storage_disk_provider', DefaultDiskProvider::class);

        if (app()->has($class)) return app()->get($class);

        return resolve($class);
    }
}