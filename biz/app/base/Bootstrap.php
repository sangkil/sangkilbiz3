<?php

namespace biz\app\base;

use yii\helpers\ArrayHelper;

/**
 * Description of BaseBootstrap
 *
 * @author Misbahul D Munir (mdmunir) <misbahuldmunir@gmail.com>
 */
class Bootstrap implements \yii\base\BootstrapInterface
{

    /**
     * 
     * @param \yii\web\Application $app
     */
    public function bootstrap($app)
    {
        if ($app instanceof \yii\web\Application) {
            $config = ArrayHelper::getValue($app->params, 'biz_config', []);

            $this->initialize($app, $config);
            if (ArrayHelper::getValue($config, 'auto_define_module', true)) {
                $this->autoDefineModule($app);
            }
        }
    }

    protected function initialize($app, $config)
    {
        
    }

    /**
     * 
     * @param \yii\web\Application $app
     */
    protected function autoDefineModule($app)
    {
        
    }
}