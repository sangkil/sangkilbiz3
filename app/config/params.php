<?php

return [
    'adminEmail' => 'admin@example.com',
    // Use for RecordLogger 
    'mdm.logger' => [
        'storage' => [
            'class' => 'mdm\logger\storages\MongoStorage',
        ],
//        'attach' => false, // default to 'db' , 
    ]
];
