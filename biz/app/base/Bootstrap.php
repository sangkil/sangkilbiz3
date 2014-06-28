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
            $config = array_merge([
                'user_properties' => true,
                'self_define_module' => true,
                ], ArrayHelper::getValue($app->params, 'biz_config', []));

            $this->initialize($app,$config);
            if ($config['self_define_module']) {
                $this->autoDefineModule($app);
            }
        }
    }

    protected function initialize($app,$config)
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