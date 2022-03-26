<?php

namespace Apsonex\SaasUtils\Utils\StorageDisks;

use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Facades\Storage;

class DefaultDiskProvider implements DiskProviderContract
{

    protected ?string $environment = null;

    public function forEnvironment(string $environment): DiskProviderContract
    {
        $this->environment = $environment;
        return $this;
    }

    /**
     * Get Public Disk
     */
    public function public(): Filesystem
    {
        return Storage::disk($this->driverNameByEnvironment('public'));
    }

    /**
     * Get Private Disk
     */
    public function private(): Filesystem
    {
        return Storage::disk($this->driverNameByEnvironment('private'));
    }

    /**
     * Get Disk Public Or Private depending upon the visibility
     */
    public function byVisibility(string $visibility): Filesystem
    {
        return $visibility === 'public' ? $this->public() : $this->private();
    }

    protected function driverNameByEnvironment($type = 'public')
    {
        return config('saas-utils.storage_disk.disk_drivers.' . $this->getEnvironment() . '.', $type);
    }

    protected function getEnvironment(): bool|string|null
    {
        if ($this->environment) return $this->environment;

        return app()->environment() ?: 'local';
    }
}