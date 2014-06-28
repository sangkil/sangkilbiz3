<?php

namespace biz\accounting\controllers;

use Yii;
use biz\accounting\models\GlHeader;
use biz\accounting\models\searchs\GlHeader as GlHeaderSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use biz\accounting\models\Coa;

/**
 * EntriGlController implements the CRUD actions for GlHeader model.
 */
class EntriGlController extends Controller
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
        $searchModel = new GlHeaderSearch;
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

        return $this->render('index', [
                'dataProvider' => $dataProvider,
                'searchModel' => $searchModel,
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
    public function actionCreate()
    {
        $model = new GlHeader;
        $details = [];
        if ($model->load(\Yii::$app->request->post()) && $model->validate()) {
            $transaction = \Yii::$app->db->beginTransaction();
            try {
                $model->save(false);
                list($saved, $details) = $model->saveRelation('glDetails');
                if ($saved === true && count($details) > 0) {
                    $balance = 0.0;
                    foreach ($details as $detail) {
                        $balance += $detail->amount;
                    }
                    if ($balance == 0) {
                        $transaction->commit();
                        return $this->redirect(['view', 'id' => $model->id_gl]);
                    }  else {
                        $model->addError('', "Details should be balance");
                    }
                } elseif ($saved) {
                    $model->addError('', "Detail cannot be blank");
                }
                $transaction->rollBack();
            } catch (\Exception $exc) {
                $transaction->rollBack();
                throw $exc;
            }
        }
        $model->setIsNewRecord(true);
        return $this->render('create', [
                'model' => $model,
                'details' => $details,
                'masters' => \biz\accounting\components\Helper::getMasters(['coa'])
        ]);
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