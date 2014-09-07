<?php

namespace biz\app\components;

use Yii;
use biz\app\base\AccessHandler;
use yii\web\View;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use biz\app\assets\BizAsset;

/**
 * Description of Helper
 *
 * @author Misbahul D Munir (mdmunir) <misbahuldmunir@gmail.com>
 */
class Helper
{
    /**
     *
     * @var AccessHandler[]
     */
    private static $_accessHendler = [];

    /**
     *
     * @param string|AccessHandler $handler
     */
    public static function registerAccessHandler($class, $handler)
    {
        if (!($handler instanceof AccessHandler)) {
            $handler = Yii::createObject($handler);
        }
        static::$_accessHendler[trim($class, '\\')][get_class($handler)] = $handler;
    }

    public static function checkAccess($action, $model)
    {
        $class = get_class($model);
        if (isset(static::$_accessHendler[$class])) {
            foreach (static::$_accessHendler[$class] as $handler) {
                if (!$handler->check(Yii::$app->getUser(), $action, $model)) {
                    return false;
                }
            }
        }

        return true;
    }

    /**
     *
     * @param View  $view
     * @param array $data
     */
    public static function bizConfig($view, $config = [], $position = View::POS_BEGIN)
    {
        $default = [
            'delay' => 1000,
            'limit' => 20,
            'checkStock' => false,
            'debug' => YII_ENV == 'dev',
            'pullUrl' => \yii\helpers\Url::to(['/master/sources/pull']),
        ];
        $js = "\n var biz = biz || {};"
            . "\n biz.config = " . Json::encode(ArrayHelper::merge($default, $config)) . ";\n";
        $view->registerJs($js, $position);
        BizAsset::register($view);
    }
}