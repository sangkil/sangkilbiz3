<?php

namespace biz\sales\controllers;

use Yii;
use biz\sales\models\Sales;
use biz\sales\models\searchs\Sales as SalesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \Exception;
use yii\base\UserException;
use biz\app\Hooks;
use biz\base\Event;
use biz\app\components\Helper as AppHelper;

/**
 * PosController implements the CRUD actions for Sales model.
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
     * Lists all Sales models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SalesSearch;
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

        return $this->render('index', [
                'dataProvider' => $dataProvider,
                'searchModel' => $searchModel,
        ]);
    }

    /**
     * Displays a single Sales model.
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
     * Creates a new Sales model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($price)
    {
        $payment_methods = [
            1 => 'Cash',
            2 => 'Bank',
        ];
        $model = new Sales([
            'id_branch' => Yii::$app->user->branch,
            'status' => Sales::STATUS_DRAFT,
            'sales_date' => date('Y-m-d')
        ]);
        $post = Yii::$app->request->post();
        if ($model->load($post)) {
            if (!empty($post['SalesDtl'])) {
                try {
                    $transaction = Yii::$app->db->beginTransaction();

                    $success = $model->save();
                    $success = $model->saveRelated('salesDtls', $post, $success);
                    if ($success) {
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
            } else {
                $model->addError('', 'Detail can not be blank');
            }
        }

        return $this->render('create', [
                'model' => $model,
                'price' => $price,
                'details' => $model->salesDtls,
                'payment_methods' => $payment_methods,
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
            $model->status = Sales::STATUS_RELEASE;
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

    /**
     * Updates an existing Sales model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param  integer $id
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

        $post = Yii::$app->request->post();
        if ($model->load($post)) {
            try {
                $transaction = Yii::$app->db->beginTransaction();
                $success = $model->save();
                $success = $model->saveRelated('salesDtls', $post, $success);
                if ($success) {
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

        return $this->render('create', [
                'model' => $model,
                'details' => $model->salesDtls,
                'payment_methods' => $payment_methods,
        ]);
    }

    /**
     * Deletes an existing Sales model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param  integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        if (!AppHelper::checkAccess('delete', $model)) {
            throw new \yii\web\ForbiddenHttpException();
        }
        $model->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Sales model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param  integer               $id
     * @return Sales                 the loaded model
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