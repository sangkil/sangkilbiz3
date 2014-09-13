<?php

namespace biz\app\rest;

use Yii;
use yii\web\ServerErrorHttpException;

/**
 * Description of DeleteAction
 *
 * @author Misbahul D Munir (mdmunir) <misbahuldmunir@gmail.com>
 */
class DeleteAction extends Action
{

    public function run($id)
    {
        $helperClass = $this->helperClass;
        if ($helperClass::delete($id) === false) {
            throw new ServerErrorHttpException('Failed to delete the object for unknown reason.');
        }
        Yii::$app->getResponse()->setStatusCode(204);
    }
}