<?php

$config = [
    'modules' => [
    ],
    'components' => [
        'view' => [
            'theme' => 'biz\adminlte\Theme'
        ],
        'authManager' => [
            'class' => 'mdm\admin\components\DbManager'
        ],
        'request' => [
            'cookieValidationKey' => '',
        ],
        'session' => [
            'cookieParams' => ['httponly' => true, 'path' => '/']
        ]
    ]
];

return $config;
