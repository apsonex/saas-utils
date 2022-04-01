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

    public function publicDiskName(): string
    {
        return $this->providerInstance()->publicDiskName();
    }

    public function private(): Filesystem
    {
        return $this->providerInstance()->private();
    }

    public function privateDiskName(): string
    {
        return $this->providerInstance()->privateDiskName();
    }

    public function default(): Filesystem
    {
        return $this->providerInstance()->default();
    }

    public function defaultDiskName(): string
    {
        return $this->providerInstance()->defaultDiskName();
    }

    public function byVisibility(string $visibility): Filesystem
    {
        return $this->providerInstance()->byVisibility($visibility);
    }

    public function byVisibilityDiskName(string $visibility): string
    {
        return $this->providerInstance()->byVisibilityDiskName($visibility);
    }

    protected function providerInstance(): DiskProviderContract
    {
        $class = config('saas-utils.storage_disk_provider', DefaultDiskProvider::class);

        if (app()->has($class)) return app()->get($class);

        return resolve($class);
    }
}