<?php

namespace biz\purchase\controllers;

use biz\purchase\components\Purchase as ApiPurchase;
use Yii;

/**
 * Description of RestPurchaseController
 *
 * @author Misbahul D Munir (mdmunir) <misbahuldmunir@gmail.com>
 */
class RestPurchaseController extends \biz\app\rest\Controller
{
    public $helperClass = 'biz\purchase\components\Purchase';

    /**
     * @inheritdoc
     */
    protected function verbs()
    {
        $verbs = parent::verbs();
        $verbs['receive'] = ['PUT', 'PATCH'];
        return $verbs;
    }

    public function actionReceive($id)
    {
        $helperClass = $this->helperClass;
        return $helperClass::receive($id, Yii::$app->getRequest()->getBodyParams());
    }
}