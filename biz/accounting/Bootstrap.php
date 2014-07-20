<?php

namespace biz\accounting;

use biz\accounting\hooks\GlHook;
use biz\accounting\hooks\InvoiceHook;

/**
 * Description of Bootstrap
 *
 * @author Misbahul D Munir (mdmunir) <misbahuldmunir@gmail.com>
 */
class Bootstrap extends \biz\app\base\Bootstrap
{
    protected $name = 'accounting';

    protected function initialize($app, $config)
    {
        if ($app instanceof \yii\web\Application) {
            $app->attachBehaviors([
                GlHook::className() => GlHook::className(),
                InvoiceHook::className() => InvoiceHook::className()
            ]);
        }
    }
}
