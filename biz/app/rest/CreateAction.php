<?php

namespace biz\app\rest;

use Yii;
use yii\helpers\Url;
use yii\web\ServerErrorHttpException;

/**
 * Description of CreateAction
 *
 * @author Misbahul D Munir (mdmunir) <misbahuldmunir@gmail.com>
 */
class CreateAction extends Action
{

    public $viewAction = 'view';
    
    public function run()
    {
        /* @var $model \yii\db\ActiveRecord */
        $helperClass = $this->helperClass;
        list($success, $model) = $helperClass::create(Yii::$app->getRequest()->getBodyParams());
        if($success){
            $response = Yii::$app->getResponse();
            $response->setStatusCode(201);
            $id = implode(',', array_values($model->getPrimaryKey(true)));
            $response->getHeaders()->set('Location', Url::toRoute([$this->viewAction, 'id' => $id], true));
        }elseif (!$model->hasErrors()) {
            throw new ServerErrorHttpException('Failed to create the object for unknown reason.');
        }
        return $model;
    }
}