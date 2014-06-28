<?php

namespace biz\sales\controllers;

use Yii;
use biz\sales\models\SalesHdr;
use biz\sales\models\searchs\SalesHdr as SalesHdrSearch;
use biz\sales\models\SalesDtl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \Exception;
use yii\base\UserException;
use biz\tools\Hooks;
use yii\db\Query;
use biz\base\Event;
use biz\master\models\Price;
use biz\master\models\PriceCategory;
use yii\helpers\ArrayHelper;
use biz\master\components\Helper;

/**
 * PosController implements the CRUD actions for SalesHdr model.
 */
class StandartController extends Controller
{

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                    'release' => ['post']
                ],
            ]
        ];
    }

    /**
     * Lists all SalesHdr models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SalesHdrSearch;
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

        return $this->render('index', [
                'dataProvider' => $dataProvider,
                'searchModel' => $searchModel,
        ]);
    }

    /**
     * Displays a single SalesHdr model.
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
     * Creates a new SalesHdr model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $payment_methods = [
            1 => 'Cash',
            2 => 'Bank',
        ];
        $model = new SalesHdr;
        $model->id_branch = Yii::$app->user->branch;
        $model->status = 1;
        $model->id_customer = 1;
        $model->sales_date = date('Y-m-d');
        list($details, $success) = $this->saveSales($model);
        if ($success) {
            return $this->redirect(['view', 'id' => $model->id_sales]);
        }
        $model->setIsNewRecord(true);
        $price_category = ArrayHelper::map(PriceCategory::find()->all(), 'id_price_category', 'nm_price_category');
        return $this->render('create', [
                'model' => $model,
                'details' => $details,
                'payment_methods' => $payment_methods,
                'masters' => $this->getDataMaster(),
                'price_category' => $price_category,
        ]);
    }

    /**
     * 
     * @param SalesHdr $model
     * @return array
     */
    protected function saveSales($model)
    {
        $post = Yii::$app->request->post();
        $details = $model->salesDtls;
        $success = false;

        if ($model->load($post)) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $formName = (new SalesDtl)->formName();
                $postDetails = empty($post[$formName]) ? [] : $post[$formName];
                if ($postDetails === []) {
                    throw new Exception('Detail tidak boleh kosong');
                }
                $objs = [];
                foreach ($details as $detail) {
                    $objs[$detail->id_sales_dtl] = $detail;
                }
                if ($model->save()) {
                    $success = true;
                    $id_hdr = $model->id_sales;
                    $id_whse = $model->id_warehouse;
                    $details = [];
                    foreach ($postDetails as $dataDetail) {
                        $id_dtl = $dataDetail['id_sales_dtl'];
                        if (isset($objs[$id_dtl])) {
                            $detail = $objs[$id_dtl];
                            unset($objs[$id_dtl]);
                        } else {
                            $detail = new SalesDtl;
                        }

                        $detail->setAttributes($dataDetail);
                        $detail->id_sales = $id_hdr;
                        $detail->id_warehouse = $id_whse;
                        if ($detail->idCogs) {
                            $detail->cogs = $detail->idCogs->cogs;
                        } else {
                            $detail->cogs = 0;
                        }
                        if (!$detail->save()) {
                            $success = false;
                            $model->addError('', implode("\n", $detail->firstErrors));
                            break;
                        }

                        $details[] = $detail;
                    }
                    if ($success && count($objs) > 0) {
                        $success = SalesDtl::deleteAll(['id_sales_dtl' => array_keys($objs)]);
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
                    $detail = new SalesDtl();
                    $detail->setAttributes($value);
                    $details[] = $detail;
                }
            }
        }
        return [$details, $success];
    }

    public function actionRelease($id)
    {
        $model = $this->findModel($id);
        Yii::$app->trigger(Hooks::E_SSREL_1, new Event([$model]));
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $model->status = SalesHdr::STATUS_RELEASE;
            if (!$model->save()) {
                throw new UserException(implode("\n", $model->getFirstErrors()));
            }
            Yii::$app->trigger(Hooks::E_SSREL_21, new Event([$model]));
            foreach ($model->salesDtls as $detail) {
                Yii::$app->trigger(Hooks::E_SSREL_22, new Event([$model, $detail]));
            }
            Yii::$app->trigger(Hooks::E_SSREL_23, new Event([$model]));
            $transaction->commit();
        } catch (Exception $exc) {
            $transaction->rollBack();
            throw new UserException($exc->getMessage());
        }
        return $this->redirect(['view', 'id' => $id]);
    }

    public function getDataMaster()
    {
        return Helper::getMasters(['product','barcode','price','customer']);
    }

    /**
     * Updates an existing SalesHdr model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $payment_methods = [
            1 => 'Cash',
            2 => 'Bank',
        ];

        list($details, $success) = $this->saveSales($model);
        if ($success) {
            return $this->redirect(['view', 'id' => $model->id_sales]);
        }
        return $this->render('update', [
                'model' => $model,
                'details' => $details,
                'payment_methods' => $payment_methods,
                'masters' => $this->getDataMaster()
        ]);
    }

    /**
     * Deletes an existing SalesHdr model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        return $this->redirect(['index']);
    }

    /**
     * 
     * @param string $action
     * @param SalesHdr $model
     * @return boolean Description
     */
    public function checkAccess($action, $model)
    {
        \Yii::$app->user->can($action);
        switch ($action) {
            case 'update':
                return $model->status == SalesHdr::STATUS_DRAFT;

            default:
                return true;
        }
    }

    /**
     * Finds the SalesHdr model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return SalesHdr the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SalesHdr::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}