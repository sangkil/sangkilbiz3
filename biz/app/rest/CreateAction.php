<?php

namespace biz\app\rest;

use Yii;

/**
 * Description of CreateAction
 *
 * @author Misbahul D Munir (mdmunir) <misbahuldmunir@gmail.com>
 */
class CreateAction extends Action
{

    public function run()
    {
        $helperClass = $this->helperClass;
        return $helperClass::create(Yii::$app->getRequest()->getBodyParams());
    }
}