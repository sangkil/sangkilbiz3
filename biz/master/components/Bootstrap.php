<?php

namespace biz\master\components;

use Yii;
use yii\db\BaseActiveRecord;
use yii\db\Expression;

/**
 * Description of Bootstrapt
 *
 * @author Misbahul D Munir (mdmunir) <misbahuldmunir@gmail.com>
 */
class Bootstrap implements \yii\base\BootstrapInterface
{

    /**
     * 
     * @param \yii\base\Application $app
     */
    public function bootstrap($app)
    {
        $this->baseConfig();
//        $app->attachBehaviors([
//            CogsHook::className() => CogsHook::className(),
//            PriceHook::className() => PriceHook::className(),
//            StockHook::className() => StockHook::className()
//        ]);
    }

    protected function baseConfig()
    {
        Yii::$container->set('BizTimestampBehavior', [
            'class' => 'yii\behaviors\TimestampBehavior',
            'attributes' => [
                BaseActiveRecord::EVENT_BEFORE_INSERT => ['created_date', 'updated_date'],
                BaseActiveRecord::EVENT_BEFORE_UPDATE => 'updated_date',
            ],
            'value' => new Expression('NOW()')
        ]);

        Yii::$container->set('BizBlameableBehavior', [
            'class' => 'yii\behaviors\BlameableBehavior',
            'attributes' => [
                BaseActiveRecord::EVENT_BEFORE_INSERT => ['created_by', 'updated_by'],
                BaseActiveRecord::EVENT_BEFORE_UPDATE => 'updated_by',
            ]
        ]);
    }
}