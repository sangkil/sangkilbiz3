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
        'biz\Bootstrap',
    ],
    'modules' => [
        'admin' => [
            'class' => 'mdm\admin\Module',
        ],
        'master' => [
            'class' => 'biz\master\Module',
        ],
        'purchase' => [
            'class' => 'biz\purchase\Module',
        ],
        'inventory' => [
            'class' => 'biz\inventory\Module',
        ],
        'sales' => [
            'class' => 'biz\sales\Module',
        ],
        'accounting' => [
            'class' => 'biz\accounting\Module',
        ],
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
