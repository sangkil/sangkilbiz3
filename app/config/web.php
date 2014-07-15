<?php

$params = array_merge(
    require(__DIR__ . '/params.php'), 
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-web',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'app\controllers',
    'bootstrap' => [
        'log',
        'biz\app\Bootstrap',
        'biz\master\Bootstrap',
        'biz\purchase\Bootstrap',
        'biz\inventory\Bootstrap',
        'biz\sales\Bootstrap',
        'biz\accounting\Bootstrap',
    ],
    'modules' => [
        'admin' => [
            'class' => 'mdm\admin\Module',
            'allowActions' => [
                '*'
            ]
        ]
    ],
    'components' => [
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ]
    ],
    'params' => $params,
];
