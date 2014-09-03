<?php

namespace biz\master\controllers;
use biz\master\components\Helper as MasterHelper;
use yii\web\Response;

class SourcesController extends \yii\web\Controller
{
    public function actionPull(array $masters)
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;
        return MasterHelper::getMasters($masters);
    }

}
