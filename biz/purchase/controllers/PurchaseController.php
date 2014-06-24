<?php

namespace biz\purchase\controllers;

use Yii;
use biz\purchase\models\PurchaseHdr;
use biz\purchase\models\searchs\PurchaseHdr as PurchaseHdrSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use biz\purchase\models\PurchaseDtl;
use \Exception;
use yii\base\UserException;
use biz\master\tools\Hooks;
use biz\master\base\Event;
use biz\master\tools\Helper;
use biz\master\models\PriceCategory;

/**
 * PurchaseHdrController implements the CRUD actions for PurchaseHdr model.
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
     * Lists all PurchaseHdr models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PurchaseHdrSearch;
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());
        $dataProvider->query->andWhere(['status' => [1]]);

        return $this->render('index', [
                'dataProvider' => $dataProvider,
                'searchModel' => $searchModel,
        ]);
    }

    /**
     * Displays a single PurchaseHdr model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
                'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new PurchaseHdr model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new PurchaseHdr;
        $model->status = PurchaseHdr::STATUS_DRAFT;
        $model->id_branch = Yii::$app->user->branch;
        $model->purchase_date = date('Y-m-d');

        list($details, $success) = $this->savePurchase($model);
        if ($success) {
            return $this->redirect(['view', 'id' => $model->id_purchase]);
        }

        return $this->render('create', [
                'model' => $model,
                'details' => $details,
                'masters' => $this->getDataMaster()
        ]);
    }

    /**
     * Updates an existing PurchaseHdr model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        Yii::$app->trigger(Hooks::E_PPUPD_1, new Event([$model]));
        if (count($model->purchaseDtls)) {
            $model->id_warehouse = $model->purchaseDtls[0]->id_warehouse;
        }
        list($details, $success) = $this->savePurchase($model);
        if ($success) {
            return $this->redirect(['view', 'id' => $model->id_purchase]);
        }

        return $this->render('update', [
                'model' => $model,
                'details' => $details,
                'masters' => $this->getDataMaster()
        ]);
    }

    /**
     * 
     * @param PurchaseHdr $model
     * @return array
     */
    protected function savePurchase($model)
    {
        $post = Yii::$app->request->post();
        $details = $model->purchaseDtls;
        $success = false;

        if ($model->load($post)) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $formName = (new PurchaseDtl)->formName();
                $postDetails = empty($post[$formName]) ? [] : $post[$formName];
                if ($postDetails === []) {
                    throw new Exception('Detail tidak boleh kosong');
                }
                $objs = [];
                foreach ($details as $detail) {
                    $objs[$detail->id_purchase_dtl] = $detail;
                }
                if (empty($model->id_warehouse) && count($details)) {
                    $model->id_warehouse = $details[0]->id_warehouse;
                }
                if ($model->save()) {
                    $success = true;
                    $id_hdr = $model->id_purchase;
                    $id_whse = $model->id_warehouse;
                    $details = [];
                    foreach ($postDetails as $dataDetail) {
                        $id_dtl = $dataDetail['id_purchase_dtl'];
                        if (isset($objs[$id_dtl])) {
                            $detail = $objs[$id_dtl];
                            unset($objs[$id_dtl]);
                        } else {
                            $detail = new PurchaseDtl;
                        }

                        $detail->setAttributes($dataDetail);
                        $detail->id_purchase = $id_hdr;
                        $detail->id_warehouse = $id_whse;
                        if (!$detail->save()) {
                            $success = false;
                            break;
                        }
                        $details[] = $detail;
                    }
                    if ($success && count($objs) > 0) {
                        $success = PurchaseDtl::deleteAll(['id_purchase_dtl' => array_keys($objs)]);
                    }
                }
                if ($success) {
                    $transaction->commit();
                } else {
                    $transaction->rollBack();
                }
            } catch (Exception $exc) {
                $success = false;
                $model->addError('', $exc->getMessage());
                $transaction->rollBack();
            }
            if (!$success) {
                $details = [];
                foreach ($postDetails as $value) {
                    $detail = new PurchaseDtl();
                    $detail->setAttributes($value);
                    $details[] = $detail;
                }
            }
        }
        return [$details, $success];
    }

    /**
     * Deletes an existing PurchaseHdr model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        Yii::$app->trigger(Hooks::E_PPDEL_1, new Event([$model]));
        $model->delete();
        return $this->redirect(['index']);
    }

    public function actionReceive($id)
    {
        $model = $this->findModel($id);
        Yii::$app->trigger(Hooks::E_PPREC_1, new Event([$model]));
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $model->status = PurchaseHdr::STATUS_RECEIVE;
            if (!$model->save()) {
                throw new UserException(implode(",\n", $model->firstErrors));
            }
            Yii::$app->trigger(Hooks::E_PPREC_21, new Event([$model]));
            foreach ($model->purchaseDtls as $detail) {
                Yii::$app->trigger(Hooks::E_PPREC_22, new Event([$model, $detail]));
            }
            Yii::$app->trigger(Hooks::E_PPREC_23, new Event([$model]));
            $transaction->commit();
        } catch (Exception $exc) {
            $transaction->rollBack();
            throw new UserException($exc->getMessage());
        }
        return $this->redirect(['index']);
    }

    /**
     * Finds the PurchaseHdr model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PurchaseHdr the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PurchaseHdr::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function getDataMaster()
    {
        return Helper::getMasters(['product', 'barcode', 'supplier', 'product_supplier']);
    }
}