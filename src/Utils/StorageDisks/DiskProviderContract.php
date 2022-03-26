<?php

namespace Apsonex\SaasUtils\Utils\StorageDisks;

use Illuminate\Contracts\Filesystem\Filesystem;

interface DiskProviderContract
{

    public function forEnvironment(string $environment): DiskProviderContract;

    public function public(): Filesystem;

    public function private(): Filesystem;

    public function byVisibility(string $visibility): Filesystem;

}