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
    public static function registerAccessHandler($class, $handler)
    {
        if (!($handler instanceof AccessHandler)) {
            $handler = \Yii::createObject($handler);
        }
        static::$_accessHendler[trim($class, '\\')][get_class($handler)] = $handler;
    }

    public static function checkAccess($action, $model)
    {
        $allow = true;
        if (isset(static::$_accessHendler[get_class($model)])) {
            foreach (static::$_accessHendler[get_class($model)] as $handler) {
                $allow = $handler->check(\Yii::$app->getUser(), $action, $model);
                if(!$allow){
                    break;
                }
            }
        }
        return $allow;
    }
}