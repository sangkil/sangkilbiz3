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
        return [
            'index' => ['GET', 'HEAD'],
            'view' => ['GET', 'HEAD'],
            'create' => ['POST'],
            'update' => ['PUT', 'PATCH'],
            'delete' => ['DELETE'],
        ];
    }
    
    public function actionCreate()
    {
        return ApiPurchase::create(Yii::$app->getRequest()->getBodyParams());
    }
    
    public function actionUpdate($id)
    {
        return ApiPurchase::update($id, Yii::$app->getRequest()->getBodyParams());
    }
}