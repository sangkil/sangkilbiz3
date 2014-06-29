<?php

namespace biz\accounting\controllers;

use Yii;
use biz\accounting\models\GlHeader;
use biz\accounting\models\searchs\GlEntriSheet;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use biz\accounting\models\EntriSheet;
use biz\accounting\models\EntriSheetDtl;
use biz\accounting\models\GlDetail;
use yii\base\Model;

/**
 * GlEntriSheetController implements the CRUD actions for GlHeader model.
 */
class GlEntriSheetController extends Controller
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
     * Lists all GlHeader models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new GlEntriSheet();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single GlHeader model.
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
     * Creates a new GlHeader model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($es = null)
    {
        $sheets = EntriSheet::find()->asArray()->all();
        $sheets = \yii\helpers\ArrayHelper::map($sheets, 'id_esheet', 'nm_esheet');
        $model = new GlHeader();
        $details = [];
        if (!empty($es)) {
            foreach (EntriSheetDtl::findAll(['id_esheet' => $es]) as $eDtl) {
                /* @var $eDtl EntriSheetDtl */
                $details[$eDtl->nm_esheet_dtl] = new GlDetail(['id_coa' => $eDtl->id_coa]);
            }

            if ($model->load(Yii::$app->request->post()) && $model->validate()) {
                $transaction = Yii::$app->db->beginTransaction();
                try {
                    $model->save(false);
                    list($saved, $details) = $model->saveRelation('glDetails');
                    if ($saved == true) {
                        $amount = 0.0;
                        foreach ($details as $dtl) {
                            $amount += $dtl->amount;
                        }
                        if ($amount == 0) {
                            $transaction->commit();
                            return $this->redirect(['view', 'id' => $model->id_gl]);
                        } else {
                            $transaction->rollBack();
                            $model->addError('', 'Details not balance');
                        }
                    } else {
                        $transaction->rollBack();
                    }
                } catch (\Exception $exc) {
                    $transaction->rollBack();
                    $model->addError('', $exc->getMessage());
                }
            }
        }
        return $this->render('create', [
                'model' => $model,
                'details' => $details,
                'es' => $es,
                'sheets' => $sheets
        ]);
    }

    /**
     * Updates an existing GlHeader model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_gl]);
        } else {
            return $this->render('update', [
                    'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing GlHeader model.
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
     * Finds the GlHeader model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return GlHeader the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = GlHeader::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}