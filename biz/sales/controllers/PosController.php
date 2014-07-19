<?php

namespace biz\sales\controllers;

use Yii;
use biz\sales\models\Sales;
use biz\sales\models\SalesDtl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use mdm\clienttools\AppCache;
use yii\db\Query;
use yii\web\Response;
use biz\sales\models\Cashdrawer;
use biz\sales\models\Cogs;
use biz\master\components\Helper;

/**
 * PosController implements the CRUD actions for Sales model.
 */
class PosController extends Controller
{

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                    'save-pos' => ['post'],
                    'open-new-drawer' => ['post'],
                    'select-drawer' => ['post']
                ],
            ],
//            [
//                'class' => AppCache::className(),
//                'actions' => [
////                    'create'
//                ]
//            ]
        ];
    }

    /**
     * Creates a new Sales model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $payment_methods = [
            1 => 'Cash',
            2 => 'Bank',
        ];

        return $this->render('create', [
                'payment_methods' => $payment_methods,
        ]);
    }

    public function actionMasters()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        return $this->getDataMaster();
    }

    public static function invalidatePos()
    {
        AppCache::invalidate('sales/pos/create');
    }

    public function actionOpenNewDrawer()
    {
        $app = Yii::$app;
        $app->response->format = Response::FORMAT_JSON;
        $model = new Cashdrawer();
        try {
            if ($model->load($app->request->post()) && $model->save()) {
                $app->clientIdBranch = $model->id_branch;
                $app->clientCashierNo = $model->cashier_no;
                return [
                    'type' => 'S',
                    'drawer' => [
                        'id_cashdrawer' => $model->id_cashdrawer,
                        'cashier_no' => $model->cashier_no,
                        'id_branch' => $model->id_branch,
                        'nm_branch' => $model->idBranch->nm_branch,
                        'username' => $app->user->identity->username,
                        'open_time' => $model->open_time
                    ]
                ];
            } else {
                return [
                    'type' => 'E',
                    'msg' => implode("\n", $model->firstErrors)
                ];
            }
        } catch (\Exception $exc) {
            return [
                'type' => 'E',
                'msg' => $exc->getMessage(),
            ];
        }
    }

    public function actionCheckDrawer()
    {
        $app = Yii::$app;
        $app->response->format = Response::FORMAT_JSON;
        $model = Cashdrawer::findOne([
                'id_user' => Yii::$app->user->id,
                'client_machine' => Yii::$app->clientId,
                'status' => Cashdrawer::STATUS_OPEN,
        ]);
        if ($model) {
            if ($model->create_at > date('Y-m-d 00:00:00')) {
                $app->clientIdBranch = $model->id_branch;
                $app->clientCashierNo = $model->cashier_no;
                return [
                    'type' => 'S',
                    'drawer' => [
                        'id_cashdrawer' => $model->id_cashdrawer,
                        'cashier_no' => $model->cashier_no,
                        'id_branch' => $model->id_branch,
                        'nm_branch' => $model->idBranch->nm_branch,
                        'username' => $app->user->identity->username,
                        'open_time' => $model->open_time
                    ]
                ];
            } else {
                return $this->redirect(['close-drawer']);
            }
        } else {
            return [
                'type' => 'E',
                'msg' => 'not found'
            ];
        }
    }

    public function actionCloseDrawer()
    {
        $model = Cashdrawer::findOne([
                'client_machine' => Yii::$app->clientId,
                'id_user' => Yii::$app->user->getId(),
                'status' => Cashdrawer::STATUS_OPEN,
        ]);

        if ($model->load(Yii::$app->request->post())) {
            $model->status = Cashdrawer::STATUS_CLOSE;
            if ($model->save()) {
                return $this->redirect(['drawer/index']);
            }
        }
        $model->status = Cashdrawer::STATUS_OPEN;
        return $this->render('close', ['model' => $model]);
    }

    public function actionSavePos()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $post = Yii::$app->request->post();
        try {
            $transaction = Yii::$app->db->beginTransaction();
            $drawer = Cashdrawer::findOne(['id_cashdrawer' => $post['id_drawer']]);
            $hdr = new Sales([
                'id_cashdrawer' => $post['id_drawer'],
                'id_branch' => $drawer->id_branch,
                'create_by' => $drawer->id_user,
            ]);
            $total = 0.0;
            $dtls = [];
            foreach ($post['detail'] as $detail) {
                $cogs = Cogs::findOne(['id_product' => $detail['id_product']]);
                $dtl = new SalesDtl([
                    'id_product' => $detail['id_product'],
                    'id_uom' => $detail['id_uom'],
                    'sales_price' => $detail['price'],
                    'sales_qty' => $detail['qty'],
                    'discount' => $detail['discon'],
                    'cogs' => $cogs ? $cogs->cogs : 0,
                ]);
                $total += $detail['qty'] * $detail['price'] * (1 - 0.01 * $detail['discon']);
                $dtls[] = $dtl;
            }

            $transaction->commit();
        } catch (\Exception $exc) {
            $transaction->rollback();
        }
        return [
            'type' => 'E'
        ];
    }

    public function actionTotalCash($id)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        return[
            'type' => 'S',
            'total' => 100000
        ];
    }

    public function getDataMaster()
    {
        return Helper::getMasters(['product', 'price', 'barcode']);
    }

    /**
     * Finds the Sales model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Sales the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Sales::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}