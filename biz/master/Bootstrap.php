<?php

namespace biz\master;

use Yii;
use yii\db\BaseActiveRecord;
use yii\db\Expression;
use biz\master\hooks\CogsHook;
use biz\master\hooks\PriceHook;
use biz\master\hooks\StockHook;
use biz\master\components\UserProperties;
use yii\validators\Validator;

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
                    BaseActiveRecord::EVENT_BEFORE_INSERT => ['create_date', 'update_date'],
                    BaseActiveRecord::EVENT_BEFORE_UPDATE => 'update_date',
                ],
                'value' => new Expression('NOW()')
            ],
            'BizBlameableBehavior' => [
                'class' => 'yii\behaviors\BlameableBehavior',
                'attributes' => [
                    BaseActiveRecord::EVENT_BEFORE_INSERT => ['create_by', 'update_by'],
                    BaseActiveRecord::EVENT_BEFORE_UPDATE => 'update_by',
                ],
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

    protected function validatorConfig($params)
    {
        $config = [
            'doubleVal' => [
                'class' => 'yii\validators\FilterValidator',
                'filter' => function($val) {
                return (double) str_replace(',', '', $val);
            }
            ]
        ];
        foreach ($config as $name => $definition) {
            if (isset($params[$name]) && is_array($params[$name])) {
                $definition = array_merge($definition, $params[$name]);
            }
            Validator::$builtInValidators[$name] = $definition;
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