<?php

namespace biz\app\rest;

use Yii;
use yii\web\ServerErrorHttpException;

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
        list($success, $model) = $helperClass::update($id, Yii::$app->getRequest()->getBodyParams());
        if(!$success && !$model->hasErrors()){
            throw new ServerErrorHttpException('Failed to update the object for unknown reason.');
        }
        return $model;
    }
}