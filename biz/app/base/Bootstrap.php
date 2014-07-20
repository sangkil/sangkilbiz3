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
    protected $name;

    /**
     *
     * @param \yii\web\Application $app
     */
    public function bootstrap($app)
    {
        if ($this->name !== null) {
            $configName = 'sangkil.biz.' . $this->name;
            $config = ArrayHelper::getValue($app->params, $configName, []);
            $this->initialize($app, $config);
            if ($app instanceof \yii\web\Application && ArrayHelper::getValue($config, 'auto_module', true)) {
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
        if ($this->name !== null) {
            $ref = new \ReflectionClass($this);
            $app->setModule($this->name, $ref->getNamespaceName() . '\Module');
        }
    }
}
