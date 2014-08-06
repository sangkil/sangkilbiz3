<?php

use yii\db\BaseActiveRecord;
use yii\db\Expression;

return [
    'BizTimestampBehavior' => [
        'class' => 'yii\behaviors\TimestampBehavior',
        'attributes' => [
            BaseActiveRecord::EVENT_BEFORE_INSERT => ['create_at', 'update_at'],
            BaseActiveRecord::EVENT_BEFORE_UPDATE => 'update_at',
        ],
        'value' => new Expression('NOW()')
    ],
    'BizBlameableBehavior' => [
        'class' => 'yii\behaviors\BlameableBehavior',
        'attributes' => [
            BaseActiveRecord::EVENT_BEFORE_INSERT => ['create_by', 'update_by'],
            BaseActiveRecord::EVENT_BEFORE_UPDATE => 'update_by',
        ],
    ],
    'BizStatusConverter' => [
        'class' => 'mdm\converter\EnumConverter',
        'attributes' => [
            'nmStatus' => 'status'
        ],
        'enumPrefix' => 'STATUS_'
    ],
    'yii\grid\ActionColumn' => [
        'class' => 'biz\app\components\ActionColumn'
    ]
];
