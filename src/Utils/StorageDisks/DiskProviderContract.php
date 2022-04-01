<?php

namespace Apsonex\SaasUtils\Utils\StorageDisks;

use Illuminate\Contracts\Filesystem\Filesystem;

interface DiskProviderContract
{

    public function forEnvironment(string $environment): DiskProviderContract;

    public function public(): Filesystem;

    public function publicDiskName(): string;

    public function private(): Filesystem;

    public function privateDiskName(): string;

    public function default(): Filesystem;

    public function defaultDiskName(): string;

    public function byVisibility(string $visibility): Filesystem;

    public function byVisibilityDiskName(string $visibility): string;

}