<?php

namespace biz\purchase\controllers;

use Yii;
use biz\purchase\models\Purchase;
use biz\purchase\models\searchs\Purchase as PurchaseSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \Exception;
use yii\base\UserException;
use biz\app\Hooks;
use biz\app\base\Event;
use biz\app\components\Helper as AppHelper;
use biz\purchase\components\Purchase as ApiPurchase;

/**
 * PurchaseController implements the CRUD actions for Purchase model.
 */
class PurchaseController extends Controller
{

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                    'receive' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Purchase models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PurchaseSearch;
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());
        $dataProvider->query->andWhere(['status' => [1]]);

        return $this->render('index', [
                'dataProvider' => $dataProvider,
                'searchModel' => $searchModel,
        ]);
    }

    /**
     * Displays a single Purchase model.
     * @param  integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
                'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Purchase model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Purchase([
            'status' => Purchase::STATUS_DRAFT,
            'id_branch' => Yii::$app->user->branch,
            'purchase_date' => date('Y-m-d')
        ]);

        $post = Yii::$app->request->post();

        if (isset($post['Purchase'])) {
            $data = $post['Purchase'];
            $data['details'] = isset($post['PurchaseDtl']) ? $post['PurchaseDtl'] : [];
            list($success, $model) = ApiPurchase::create($data, $model);
            if ($success) {
                return $this->redirect(['view', 'id' => $model->id_purchase]);
            }
        }
        return $this->render('create', [
                'model' => $model,
                'details' => $model->purchaseDtls
        ]);
    }

    /**
     * Updates an existing Purchase model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param  integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        
        $post = Yii::$app->request->post();

        if (isset($post['Purchase'])) {
            $data = $post['Purchase'];
            $data['details'] = isset($post['PurchaseDtl']) ? $post['PurchaseDtl'] : [];
            list($success, $model) = ApiPurchase::update($id, $data, $model);
            if ($success) {
                return $this->redirect(['view', 'id' => $model->id_purchase]);
            }
        }

        return $this->render('update', [
                'model' => $model,
                'details' => $model->purchaseDtls
        ]);
    }

    /**
     * Deletes an existing Purchase model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param  integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        ApiPurchase::delete($id);

        return $this->redirect(['index']);
    }

    public function actionReceive($id)
    {
        ApiPurchase::receive($id);

        return $this->redirect(['index']);
    }

    /**
     * Finds the Purchase model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param  integer               $id
     * @return Purchase              the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Purchase::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}