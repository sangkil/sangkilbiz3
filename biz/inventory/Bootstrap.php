<?php

namespace biz\inventory;

use biz\app\components\Helper as AppHelper;
use biz\inventory\components\AccessHandler;

/**
 * Description of Bootstrap
 *
 * @author Misbahul D Munir (mdmunir) <misbahuldmunir@gmail.com>
 */
class Bootstrap extends \biz\app\base\Bootstrap
{
    protected $name = 'inventory';

    /**
     *
     * @param \yii\web\Application $app
     * @param array                $config
     */
    protected function initialize($app, $config)
    {
        if ($app instanceof \yii\web\Application) {
            $app->attachBehaviors([
                hooks\TransferNoticeHook::className() => hooks\TransferNoticeHook::className(),
            ]);
            AppHelper::registerAccessHandler(models\Transfer::className(), AccessHandler::className());
            AppHelper::registerAccessHandler(models\TransferNotice::className(), AccessHandler::className());
        }
    }
}
