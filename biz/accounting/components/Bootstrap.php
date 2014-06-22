<?php

namespace biz\accounting\components;

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
            GlHook::className() => GlHook::className(),
            InvoiceHook::className() => InvoiceHook::className()
        ]);
    }
}