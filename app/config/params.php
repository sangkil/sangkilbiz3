<?php

return [
    'adminEmail' => 'admin@example.com',
    // Use for RecordLogger 
    'mdm.logger' => [
        'storage' => [
            'class' => 'mdm\logger\storages\MongoStorage',
        ],
        'attachTo' => ['db'], // set to false
    ],
    // sangkil biz
    'sangkil.biz.app' => [
    ],
    'sangkil.biz.master' => [
    ],
    'sangkil.biz.purchase' => [
    ],
    'sangkil.biz.inventory' => [
    ],
    'sangkil.biz.sales' => [
        'attach_client_behavior' => true, // 
    ],
    'sangkil.biz.accounting' => [
    ],
];
