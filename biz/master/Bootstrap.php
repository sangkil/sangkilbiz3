<?php

namespace biz\master;

use Yii;
use yii\db\BaseActiveRecord;
use yii\db\Expression;
use biz\master\hooks\CogsHook;
use biz\master\hooks\PriceHook;
use biz\master\hooks\StockHook;
use biz\master\components\UserProperties;

/**
 * Description of Bootstrapt
 *
 * @author Misbahul D Munir (mdmunir) <misbahuldmunir@gmail.com>
 */
class Bootstrap extends base\Bootstrap
{

    /**
     * 
     * @param \yii\base\Application $app
     */
    protected function initialize($app, $config)
    {
        $this->diConfig($config);
        if ($config['user_properties']) {
            $this->attachUserProperty($app->getUser());
        }
        $this->attachHooks($app);
    }

    /**
     * 
     * @param \yii\web\User $user
     */
    protected function attachUserProperty($user)
    {
        $user->attachBehavior(UserProperties::className(), UserProperties::className());
    }

    /**
     * 
     * @param \yii\web\Application $app
     */
    protected function attachHooks($app)
    {
        $app->attachBehaviors([
            CogsHook::className() => CogsHook::className(),
            PriceHook::className() => PriceHook::className(),
            StockHook::className() => StockHook::className()
        ]);
    }

    /**
     * 
     * @param array $params
     */
    protected function diConfig($params)
    {
        $config = [
            'BizTimestampBehavior' => [
                'class' => 'yii\behaviors\TimestampBehavior',
                'attributes' => [
                    BaseActiveRecord::EVENT_BEFORE_INSERT => ['created_date', 'updated_date'],
                    BaseActiveRecord::EVENT_BEFORE_UPDATE => 'updated_date',
                ],
                'value' => new Expression('NOW()')
            ],
            'BizBlameableBehavior' => [
                'class' => 'yii\behaviors\BlameableBehavior',
            ],
            'BizStatusConverter' => [
                'class' => 'mdm\converter\EnumConverter',
                'attributes' => [
                    'nmStatus' => 'status'
                ],
                'enumPrefix' => 'STATUS_'
            ],
        ];

        foreach ($config as $class => $definition) {
            if (isset($params[$class]) && is_array($params[$class])) {
                $definition = array_merge($definition, $params[$class]);
            }
            Yii::$container->set($class, $definition);
        }
    }

    /**
     * 
     * @param \yii\web\Application $app
     */
    protected function autoDefineModule($app)
    {
        $app->setModule('master', Module::className());
    }
}