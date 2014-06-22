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
        $app->attachBehaviors([
            CogsHook::className() => CogsHook::className(),
            PriceHook::className() => PriceHook::className(),
//            StockHook::className() => StockHook::className()
        ]);
    }
}