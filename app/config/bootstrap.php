<?php

// set aliases
Yii::setAlias('biz', dirname(dirname(__DIR__)) . '/biz');

// Check access to $model before show button
Yii::$container->set('yii\grid\ActionColumn', 'biz\app\components\ActionColumn');
