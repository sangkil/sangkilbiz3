<?php
$config = [
    'modules' => [
    ],
    'components' => [
        'view'=>[
            'theme' => 'biz\adminlte\Theme'
        ],
        'authManager' => [
            'class' => 'mdm\admin\components\DbManager'
        ],
        'request' => [
            'cookieValidationKey' => md5(__FILE__),
        ]
    ]
];

return $config;