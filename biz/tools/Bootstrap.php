<?php

namespace biz\tools;

use Yii;
use yii\db\BaseActiveRecord;
use yii\db\Expression;
use yii\helpers\ArrayHelper;

/**
 * Description of Bootstrapt
 *
 * @author Misbahul D Munir (mdmunir) <misbahuldmunir@gmail.com>
 */
class Bootstrap implements \yii\base\BootstrapInterface
{

    /**
     * 
     * @param \yii\base\Application $app
     */
    public function bootstrap($app)
    {
        $this->diConfig($app->params);
    }

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
                'attributes' => [
                    BaseActiveRecord::EVENT_BEFORE_INSERT => ['created_by', 'updated_by'],
                    BaseActiveRecord::EVENT_BEFORE_UPDATE => 'updated_by',
                ]
            ]
        ];

        foreach ($config as $class => $definition) {
            if (isset($params[$class]) && is_array($params[$class])) {
                $definition = ArrayHelper::merge($definition, $params[$class]);
            }
            Yii::$container->set($class, $definition);
        }
    }
}