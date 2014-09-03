<?php

namespace biz\accounting\controllers;

use Yii;
use biz\accounting\models\Payment;
use biz\accounting\models\searchs\Payment as PaymentSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use biz\accounting\models\searchs\InvoicePayment as InvoicePaymentSearch;
use yii\db\Query;
use biz\accounting\models\Invoice;
use biz\accounting\models\PaymentDtl;

/**
 * PaymentController implements the CRUD actions for Payment model.
 */
class PaymentController extends Controller
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
     * Lists all Payment models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PaymentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Payment model.
     * @param  integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
                'model' => $this->findModel($id),
        ]);
    }

    public function actionListInvoice($type)
    {
        $searchModel = new InvoicePaymentSearch([
            'invoice_type' => $type,
        ]);
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());
        /* @var $query \yii\db\ActiveQuery */
        $query = clone $dataProvider->query;

        $jmlInv = (new Query())
            ->select('sum({{dtl.trans_value}})')
            ->from(['dtl' => '{{%invoice_dtl}}'])
            ->innerJoin(['q' => $query], '{{q.id_invoice}}={{dtl.id_invoice}}')
            ->scalar();

        $jmlPaid = (new Query())
            ->select('sum({{dtl.payment_value}})')
            ->from(['dtl' => '{{%payment_dtl}}'])
            ->innerJoin(['q' => $query], '{{q.id_invoice}}={{dtl.id_invoice}}')
            ->scalar();

        $dataProvider->query->with('paymentDtl');

        return $this->render('list_invoice', [
                'dataProvider' => $dataProvider,
                'searchModel' => $searchModel,
                'type' => $type,
                'jmlInv' => $jmlInv,
                'jmlPaid' => $jmlPaid,
                'jmlRemain' => $jmlInv - $jmlPaid,
        ]);
    }

    /**
     * Creates a new Payment model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($type, $ids)
    {
        $model = new Payment();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            try {
                $transaction = Yii::$app->db->beginTransaction();
                $model->save(false);
                $details = $model->saveRelated('paymentDtl');
                if ($details === true) {
                    $transaction->commit();

                    return $this->redirect(['view', 'id' => $model->id_payment]);
                } else {
                    $transaction->rollBack();
                }
            } catch (\Exception $e) {
                $transaction->rollBack();
                $model->addError('', $e->getMessage());
            }
        }
        $query = Invoice::find()->where([
            'invoice_type' => $type,
            'id_invoice' => explode(',', $ids)
        ]);
        $jmlInv = (new Query())
            ->select('sum({{dtl.trans_value}})')
            ->from(['dtl' => '{{%invoice_dtl}}'])
            ->innerJoin(['q' => $query], '{{q.id_invoice}}={{dtl.id_invoice}}')
            ->scalar();

        $jmlPaid = (new Query())
            ->select('sum({{dtl.payment_value}})')
            ->from(['dtl' => '{{%payment_dtl}}'])
            ->innerJoin(['q' => $query], '{{q.id_invoice}}={{dtl.id_invoice}}')
            ->scalar();
        if (!isset($details)) {
            $details = [];
            foreach ($query->all() as $hdr) {
                $detail = new PaymentDtl([
                    'id_invoice' => $hdr->id_invoice,
                ]);
                $details[] = $detail;
            }
        }

        return $this->render('create', [
                'model' => $model,
                'details' => $details,
                'type' => $type,
                'jmlInv' => $jmlInv,
                'jmlPaid' => $jmlPaid,
                'jmlRemain' => $jmlInv - $jmlPaid,
        ]);
    }

    /**
     * Updates an existing Payment model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param  integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_payment]);
        } else {
            return $this->render('update', [
                    'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Payment model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param  integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Payment model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param  integer               $id
     * @return Payment               the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Payment::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
