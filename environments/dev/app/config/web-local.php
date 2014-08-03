<?php

$config = [
    'modules' => [
    ],
    'components' => [
        'view' => [
//            'theme' => 'biz\adminlte\Theme'
        ],
        'authManager' => [
            'class' => 'mdm\admin\components\DbManager'
        ],
        'assetManager' => [
            'forceCopy' => true,
        ],
        'request' => [
            'cookieValidationKey' => '',
        ]
    ]
];

if (!YII_ENV_TEST) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = 'yii\debug\Module';

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = 'yii\gii\Module';
}

return $config;
