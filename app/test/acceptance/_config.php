<?php

return yii\helpers\ArrayHelper::merge(
    require(__DIR__ . '/../../config/common.php'),
    require(__DIR__ . '/../../config/common-local.php'),
    require(__DIR__ . '/../../config/web.php'),
    require(__DIR__ . '/../../config/web-local.php'),
    require(__DIR__ . '/../_config.php'),
    [
        'components' => [
            'db' => [
                'dsn' => 'mysql:host=localhost;dbname=sangkilbiz3_acceptance',
            ],
        ],
    ]
);
