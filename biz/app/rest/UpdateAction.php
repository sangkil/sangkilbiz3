<?php

namespace biz\app\rest;

use Yii;

/**
 * Description of UpdateAction
 *
 * @author Misbahul D Munir (mdmunir) <misbahuldmunir@gmail.com>
 */
class UpdateAction extends Action
{

    public function run($id)
    {
        $helperClass = $this->helperClass;
        return $helperClass::update($id, Yii::$app->getRequest()->getBodyParams());
    }
}