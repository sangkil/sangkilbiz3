<?php

namespace biz\inventory\controllers;

use Yii;
use biz\inventory\models\Transfer;
use biz\inventory\models\searchs\Transfer as TransferSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \Exception;
use yii\base\UserException;
use biz\app\Hooks;
use biz\app\base\Event;
use biz\app\components\Helper as AppHelper;

/**
 * TransferController implements the CRUD actions for Transfer model.
 */
class TransferController extends Controller
{

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                    'issue' => ['post'],
                    'confirm' => ['post'],
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
        return $this->render('view', [
                'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Transfer model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Transfer;
        $model->status = Transfer::STATUS_DRAFT;

        try {
            $transaction = Yii::$app->db->beginTransaction();
            $result = $model->saveRelation('transferDtls', Yii::$app->request->post());
            if ($result === 1) {
                $transaction->commit();

                return $this->redirect(['view', 'id' => $model->id_transfer]);
            } else {
                $transaction->rollBack();
            }
        } catch (\Exception $exc) {
            $transaction->rollBack();
            $model->addError('', $exc->getMessage());
        }

        $model->setIsNewRecord(true);

        return $this->render('create', [
                'model' => $model,
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
        if (!AppHelper::checkAccess('update', $model)) {
            throw new \yii\web\ForbiddenHttpException();
        }
        Yii::$app->trigger(Hooks::E_ITUPD_1, new Event([$model]));

        try {
            $transaction = Yii::$app->db->beginTransaction();
            $result = $model->saveRelation('transferDtls', Yii::$app->request->post());
            if ($result === 1) {
                $transaction->commit();

                return $this->redirect(['view', 'id' => $model->id_transfer]);
            } else {
                $transaction->rollBack();
            }
        } catch (\Exception $exc) {
            $transaction->rollBack();
            $model->addError('', $exc->getMessage());
        }

        return $this->render('update', [
                'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Transfer model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param  integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        Yii::$app->trigger(Hooks::E_ITDEL_1, new Event([$model]));
        if (!AppHelper::checkAccess('delete', $model)) {
            throw new \yii\web\ForbiddenHttpException();
        }
        $model->delete();

        return $this->redirect(['index']);
    }

    public function actionIssue($id)
    {
        $model = $this->findModel($id);
        Yii::$app->trigger(Hooks::E_ITISS_1, new Event([$model]));
        if (!AppHelper::checkAccess('issue', $model)) {
            throw new \yii\web\ForbiddenHttpException();
        }
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $model->status = Transfer::STATUS_ISSUE;
            if (!$model->save()) {
                throw new UserException(implode(",\n", $model->firstErrors));
            }
            Yii::$app->trigger(Hooks::E_ITISS_21, new Event([$model]));
            foreach ($model->transferDtls as $detail) {
                Yii::$app->trigger(Hooks::E_ITISS_22, new Event([$model, $detail]));
            }
            Yii::$app->trigger(Hooks::E_ITISS_23, new Event([$model]));
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
}
