<?php

return yii\helpers\ArrayHelper::merge(
    require(__DIR__ . '/../../config/common.php'),
    require(__DIR__ . '/../../config/common-local.php'),
    require(__DIR__ . '/../../config/console.php'),
    require(__DIR__ . '/../../config/console-local.php'),
    [
        'components' => [
            'db' => [
                'dsn' => 'mysql:host=localhost;dbname=sangkilbiz3_acceptance',
            ],
        ],
    ]
);
