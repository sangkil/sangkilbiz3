<?php

namespace biz\inventory\controllers;

use Yii;
use biz\inventory\models\Transfer;
use biz\inventory\models\searchs\Transfer as TransferSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \Exception;
use biz\app\Hooks;
use yii\base\UserException;
use biz\app\base\Event;
use biz\master\components\Helper as MasterHelper;
use biz\app\components\Helper as AppHelper;

/**
 * TransferController implements the CRUD actions for Transfer model.
 */
class ReceiveController extends Controller
{

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'receive-confirm' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Transfer models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TransferSearch;
        $params = Yii::$app->request->getQueryParams();
        $dataProvider = $searchModel->search($params);
        $dataProvider->query->andWhere('status > 1');

        return $this->render('index', [
                'dataProvider' => $dataProvider,
                'searchModel' => $searchModel,
        ]);
    }

    /**
     * Displays a single Transfer model.
     * @param  integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', ['model' => $this->findModel($id)]);
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
        $model->scenario = TransferSearch::SCENARIO_RECEIVE;
        Yii::$app->trigger(Hooks::E_IRUPD_1, new Event([$model]));
        if (!AppHelper::checkAccess('update', $model)) {
            throw new \yii\web\ForbiddenHttpException();
        }
        $post = Yii::$app->request->post();
        if ($model->load($post)) {
            try {
                $transaction = Yii::$app->db->beginTransaction();
                $model->status = Transfer::STATUS_DRAFT_RECEIVE;
                $success = $model->save();
                $success = $model->saveRelation('transferDtls', $post) && $success;
                if ($success) {
                    $transaction->commit();

                    return $this->redirect(['view', 'id' => $model->id_transfer]);
                } else {
                    $transaction->rollBack();
                }
            } catch (\Exception $exc) {
                $transaction->rollBack();
                $model->addError('', $exc->getMessage());
            }
        }

        return $this->render('update', [
                'model' => $model,
                'details' => $model->transferDtls,
                'masters' => $this->getDataMaster()
        ]);
    }

    public function actionReceive($id)
    {
        $model = $this->findModel($id);
        Yii::$app->trigger(Hooks::E_IRREC_1, new Event([$model]));
        if (!AppHelper::checkAccess('receive', $model)) {
            throw new \yii\web\ForbiddenHttpException();
        }
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $model->status = Transfer::STATUS_RECEIVE;
            if (!$model->save()) {
                throw new UserException(implode(",\n", $model->firstErrors));
            }
            Yii::$app->trigger(Hooks::E_IRREC_21, new Event([$model]));
            foreach ($model->transferDtls as $detail) {
                Yii::$app->trigger(Hooks::E_IRREC_22, new Event([$model, $detail]));
            }
            Yii::$app->trigger(Hooks::E_IRREC_23, new Event([$model]));
            $transaction->commit();
        } catch (Exception $exc) {
            $transaction->rollBack();
            throw new UserException($exc->getMessage());
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the Transfer model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param  integer               $id
     * @return Transfer              the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Transfer::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function getDataMaster()
    {
        return MasterHelper::getMasters('product, barcode, product_stock');
    }
}
