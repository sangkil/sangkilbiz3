<?php

// set aliases
Yii::setAlias('biz', dirname(dirname(__DIR__)) . '/biz');

// set DI
$container = yii\helpers\ArrayHelper::merge(
    require(__DIR__ . '/container.php'), 
    require(__DIR__ . '/container-local.php')
);

foreach ($container as $key => $value) {
    Yii::$container->set($key, $value);
}
