<?php

namespace biz\app\rest;

use Yii;
use biz\app\base\Event;

/**
 * Description of ViewAction
 *
 * @author Misbahul D Munir (mdmunir) <misbahuldmunir@gmail.com>
 */
class ViewAction extends Action
{

    public function run($id)
    {
        $helperClass = $this->helperClass;
        $model = $helperClass::findModel($id);
        $e_name = $helperClass::prefixEventName();
        Yii::$app->trigger($e_name . '_view', new Event([$model]));
        return $model;
    }
}