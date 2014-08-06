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
        }
    }

    protected function initialize($app, $config)
    {

    }
}
