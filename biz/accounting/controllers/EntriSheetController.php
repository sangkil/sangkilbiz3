<?php

namespace biz\accounting\controllers;

use Yii;
use biz\accounting\models\EntriSheet;
use biz\accounting\models\searchs\EntriSheet as EntriSheetSearch;
use biz\accounting\models\EntriSheetDtl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use biz\accounting\models\Coa;

/**
 * EntriSheetController implements the CRUD actions for EntriSheet model.
 */
class EntriSheetController extends Controller
{

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all EntriSheet models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new EntriSheetSearch;
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

        return $this->render('index', [
                'dataProvider' => $dataProvider,
                'searchModel' => $searchModel,
        ]);
    }

    /**
     * Displays a single EntriSheet model.
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
     * Creates a new EntriSheet model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new EntriSheet;
        $details = [];
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            try {
                $transaction = Yii::$app->db->beginTransaction();
                $model->save(false);
                list($saved, $details) = $model->saveRelation('entriSheetDtls');
                if ($saved == true) {
                    $transaction->commit();
                    return $this->redirect(['view', 'id' => $model->id_esheet]);
                } else {
                    $transaction->rollBack();
                }
            } catch (\Exception $exc) {
                $transaction->rollBack();
                throw $exc;
            }
            $model->setIsNewRecord(true);
        }
        return $this->render('create', [
                'model' => $model,
                'details' => $details,
                'masters' => \biz\accounting\components\Helper::getMasters(['coa'])
        ]);
    }

    /**
     * Updates an existing EntriSheet model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $details = $model->entriSheetDtls;
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            try {
                $transaction = Yii::$app->db->beginTransaction();
                $model->save(false);
                list($saved, $details) = $model->saveRelation('entriSheetDtls');
                if ($saved == true) {
                    $transaction->commit();
                    return $this->redirect(['view', 'id' => $model->id_esheet]);
                } else {
                    $transaction->rollBack();
                }
            } catch (\Exception $exc) {
                $transaction->rollBack();
                throw $exc;
            }
        }
        return $this->render('update', [
                'model' => $model,
                'details' => $details,
                'masters' => \biz\accounting\components\Helper::getMasters(['coa'])
        ]);
    }

    /**
     * Deletes an existing EntriSheet model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        try {
            $transaction = \Yii::$app->db->beginTransaction();
            EntriSheetDtl::deleteAll(['id_esheet' => $model->id_esheet]);
            $model->delete();
            $transaction->commit();
        } catch (\Exception $exc) {
            $transaction->rollBack();
            throw $exc;
        }
        return $this->redirect(['index']);
    }

    /**
     * Finds the EntriSheet model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return EntriSheet the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = EntriSheet::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}