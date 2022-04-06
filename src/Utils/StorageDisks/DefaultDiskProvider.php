<?php

namespace Apsonex\SaasUtils\Utils\StorageDisks;

use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Facades\Storage;

class DefaultDiskProvider implements DiskProviderContract
{

    protected ?string $environment = null;

    public function forEnvironment(string $environment): DiskProviderContract
    {
        $self = new static;

        $self->environment = $environment;

        return $self;
    }

    /**
     * Get Public Disk
     */
    public function public(): Filesystem
    {
        return Storage::disk($this->driverName('public'));
    }

    /**
     * Get Private Disk
     */
    public function private(): Filesystem
    {
        return Storage::disk($this->driverName('private'));
    }

    /**
     * Get Private Disk
     */
    public function default(): Filesystem
    {
        return Storage::disk();
    }

    /**
     * Get Disk Public Or Private depending upon the visibility
     */
    public function byVisibility(string $visibility): Filesystem
    {
        return $visibility === 'public' ? $this->public() : $this->private();
    }

    /**
     * Get Disk Public Or Private depending upon the visibility
     */
    public function byVisibilityDiskName(string $visibility): string
    {
        return $this->byVisibility($visibility)->getConfig()['driver'];
    }

    protected function driverName($type = 'public')
    {
        return config('saas-utils.storage_disk.disk_drivers.' . $this->getEnvironment() . '.' . $type);
    }

    public function publicDiskName(): string
    {
        return config('saas-utils.storage_disk.disk_drivers.' . $this->getEnvironment() . '.public');
    }

    public function privateDiskName(): string
    {
        return config('saas-utils.storage_disk.disk_drivers.' . $this->getEnvironment() . '.private');
    }

    public function defaultDiskName(): string
    {
        return config('filesystems.default');
    }

    protected function getEnvironment(): bool|string|null
    {
        if ($this->environment) return $this->environment;

        return app()->environment();
    }
}
