<?php

namespace biz\app\components;

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
    public static function registerAccessHandler($handler)
    {
        if (!($handler instanceof AccessHandler)) {
            $handler = \Yii::createObject($handler);
        }
        foreach ($handler->modelClasses() as $class) {
            static::$_accessHendler[trim($class, '\\')] = $handler;
        }
    }

    public static function checkAccess($action, $model)
    {
        if (isset(static::$_accessHendler[get_class($model)])) {
            $handler = static::$_accessHendler[get_class($model)];
            return $handler->check(\Yii::$app->getUser(), $action, $model);
        } else {
            return true;
        }
    }
}