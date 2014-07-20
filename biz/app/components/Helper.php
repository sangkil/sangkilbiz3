<?php

namespace biz\app\components;

use Yii;
use biz\app\base\AccessHandler;

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
}
