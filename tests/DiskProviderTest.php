<?php

namespace Apsonex\SaasUtils\Tests;

use Apsonex\SaasUtils\Facades\DiskProvider;

class DiskProviderTest extends TestCase
{

    /** @test */
    public function facade_call_underlying_disk_provider()
    {
        $this->assertEquals('local', DiskProvider::public()->getConfig()['driver']);
    }

}