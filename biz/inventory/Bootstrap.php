<?php

namespace biz\inventory;

use biz\app\components\Helper;
use biz\inventory\components\AccessHandler;

/**
 * Description of Bootstrap
 *
 * @author Misbahul D Munir (mdmunir) <misbahuldmunir@gmail.com>
 */
class Bootstrap extends \biz\app\base\Bootstrap
{

    protected function autoDefineModule($app)
    {
        $app->setModule('inventory', Module::className());
    }

    /**
     * 
     * @param \yii\web\Application $app
     * @param array $config
     */
    protected function initialize($app, $config)
    {
        $app->attachBehaviors([
            hooks\TransferNoticeHook::className() => hooks\TransferNoticeHook::className(),
        ]);
        Helper::registerAccessHandler(models\Transfer::className(), AccessHandler::className());
        Helper::registerAccessHandler(models\TransferNotice::className(), AccessHandler::className());
    }
}