<?php

namespace biz\app;

use Yii;
use yii\db\BaseActiveRecord;
use yii\db\Expression;

/**
 * Description of Bootstrapt
 *
 * @author Misbahul D Munir (mdmunir) <misbahuldmunir@gmail.com>
 */
class Bootstrap extends \biz\app\base\Bootstrap
{
    protected $name = 'app';

    /**
     * 
     * @param \yii\base\Application $app
     */
    protected function initialize($app, $config)
    {
        $this->diConfig(isset($config['container_definitions']) ? $config['container_definitions'] : []);
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
                    BaseActiveRecord::EVENT_BEFORE_INSERT => ['create_at', 'update_at'],
                    BaseActiveRecord::EVENT_BEFORE_UPDATE => 'update_at',
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
        $currentDefinitions = Yii::$container->definitions;
        foreach ($config as $class => $definition) {
            if (isset($currentDefinitions[$class])) {
                continue;
            }
            if (isset($params[$class]) && is_array($params[$class])) {
                $definition = array_merge($definition, $params[$class]);
            }
            Yii::$container->set($class, $definition);
        }
    }

    protected function autoDefineModule($app)
    {
        // nothing to do
    }
}