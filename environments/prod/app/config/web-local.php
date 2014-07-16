<?php
$config = [
    'modules' => [
    ],
    'components' => [
        'view'=>[
            'theme' => 'biz\adminlte\Theme'
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager'
        ]
    ]
];

return $config;