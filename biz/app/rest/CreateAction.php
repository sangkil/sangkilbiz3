<?php

namespace biz\app\rest;

use Yii;
use yii\helpers\Url;

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
        $model = $helperClass::create(Yii::$app->getRequest()->getBodyParams());
        if(!$model->hasErrors()){
            $response = Yii::$app->getResponse();
            $response->setStatusCode(201);
            $id = implode(',', array_values($model->getPrimaryKey(true)));
            $response->getHeaders()->set('Location', Url::toRoute([$this->viewAction, 'id' => $id], true));
        }
        return $model;
    }
}