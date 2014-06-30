<?php

namespace biz\sales\controllers;

use Yii;
use biz\sales\models\SalesHdr;
use biz\sales\models\searchs\SalesHdr as SalesHdrSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \Exception;
use yii\base\UserException;
use biz\app\Hooks;
use biz\base\Event;
use biz\master\models\PriceCategory;
use yii\helpers\ArrayHelper;
use biz\master\components\Helper;
use biz\app\components\Helper as AppHelper;

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
        $model = new SalesHdr([
            'id_branch' => Yii::$app->user->branch,
            'status' => SalesHdr::STATUS_DRAFT,
            'sales_date' => date('Y-m-d')
        ]);
        $details = [];
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            try {
                $transaction = Yii::$app->db->beginTransaction();
                $model->save(false);
                list($saved, $details) = $model->saveRelation('salesDtls', [
                    'extra' => ['id_warehouse' => $model->id_warehouse]
                ]);
                if ($saved) {
                    $transaction->commit();
                    return $this->redirect(['view', 'id' => $model->id_sales]);
                } else {
                    $transaction->rollBack();
                }
            } catch (\Exception $exc) {
                $transaction->rollBack();
                $model->addError('', $exc->getMessage());
            }
            $model->setIsNewRecord(true);
        }

        $price_category = ArrayHelper::map(PriceCategory::find()->all(), 'id_price_category', 'nm_price_category');
        return $this->render('create', [
                'model' => $model,
                'details' => $details,
                'payment_methods' => $payment_methods,
                'masters' => $this->getDataMaster(),
                'price_category' => $price_category,
        ]);
    }

    public function actionRelease($id)
    {
        $model = $this->findModel($id);
        if (!AppHelper::checkAccess('release', $model)) {
            throw new \yii\web\ForbiddenHttpException();
        }
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
        return Helper::getMasters(['product', 'barcode', 'price', 'customer']);
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
        if (!AppHelper::checkAccess('update', $model)) {
            throw new \yii\web\ForbiddenHttpException();
        }
        $payment_methods = [
            1 => 'Cash',
            2 => 'Bank',
        ];
        $details = $model->salesDtls;

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            try {
                $transaction = Yii::$app->db->beginTransaction();
                $model->save(false);
                list($saved, $details) = $model->saveRelation('salesDtls', [
                    'extra' => ['id_warehouse' => $model->id_warehouse]
                ]);
                if ($saved) {
                    $transaction->commit();
                    return $this->redirect(['view', 'id' => $model->id_sales]);
                } else {
                    $transaction->rollBack();
                }
            } catch (\Exception $exc) {
                $transaction->rollBack();
                $model->addError('', $exc->getMessage());
            }
        }

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