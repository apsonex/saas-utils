<?php

return [

    /**
     * Storage Disk Provider
     */
    'storage_disk' => [

        'provider' => \Apsonex\SaasUtils\Utils\StorageDisks\DiskProvider::class,

        'disk_drivers' => [

            'local' => ['public' => 'local', 'private' => 'local'],

            'testing' => ['public' => 'we', 'private' => 'local'],

            'production' => ['public' => 's3', 'private' => 's3_private'],

        ]

    ]

];