<?php

namespace biz\sales;

use biz\app\components\Helper as AppHelper;
use mdm\clienttools\ClientBehavior;
use yii\helpers\ArrayHelper;

/**
 * Description of Bootstrap
 *
 * @author Misbahul D Munir (mdmunir) <misbahuldmunir@gmail.com>
 */
class Bootstrap extends \biz\app\base\Bootstrap
{
    protected $name = 'sales';

    /**
     * 
     * @param \yii\web\Application $app
     * @param array $config
     */
    protected function initialize($app, $config)
    {
        if ($app instanceof \yii\web\Application) {
            if (ArrayHelper::getValue($config, 'attach_client_behavior', true)) {
                $app->attachBehavior(ClientBehavior::className(), ClientBehavior::className());
            }
            AppHelper::registerAccessHandler(models\Sales::className(), components\AccessHandler::className());
        }
    }
}