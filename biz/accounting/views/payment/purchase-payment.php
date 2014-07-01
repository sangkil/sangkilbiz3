<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var biz\models\searchs\Invoice $searchModel
 */
$this->title = 'Invoice Hdrs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="invoice-hdr-index">
    <div class="box box-info">
        <?php $form = ActiveForm::begin(); ?>
        <div class="box-body">
            <table border="0" style="width: 100%;">
                <tbody>
                    <tr>
                        <td>
                            <?= $form->field($payment, 'payment_num')->textInput(['style' => 'width:150px;']) ?>
                        </td>
                        <td>
                            <?= $form->field($payment, 'payment_type')->dropDownList(['Cash', 'Bank BNI', 'Bank Mandiri'], ['style' => 'width:150px;']) ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <?= $form->field($payment, 'payment_date')->textInput(['style' => 'width:150px;']) ?>
                        </td>
                        <td>
                            <div class="form-group">
                                <?= Html::label('Total Paid'); ?>
                                <?= Html::textInput('totalPaid', '0', ['class' => 'form-control', 'style' => 'width:200px;']); ?>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>


        </div>           
        <?php
        echo GridView::widget([
            'id' => 'inv_grid',
            'dataProvider' => $dataProvider,
            'showFooter' => true, 'tableOptions' => ['class' => 'table table-striped'],
            'layout' => '{items}',
            //'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                //'id_invoice',
                'invoice_num',
                'invoiceDtl.idPurchase.purchase_num',
                'idSupplier.nm_supplier',
                //'invDate',
                'dueDate',
                //'id_vendor',
                ['class' => 'yii\grid\DataColumn',
                    'header' => 'Nilai Invoice',
                    'value' => 'invoice_value',
                    'format' => 'number',
                    'footer' => number_format($jmlInv),
                    'footerOptions' => ['style' => 'text-align:right; font-weight: bold;'],
                    'contentOptions' => ['style' => 'text-align:right;']],
                ['class' => 'yii\grid\DataColumn',
                    'header' => 'Di Bayar',
                    'value' => 'paid',
                    'format' => 'number',
                    'footer' => number_format($jmlPaid),
                    'footerOptions' => ['style' => 'text-align:right; font-weight: bold;'],
                    'contentOptions' => ['style' => 'text-align:right;']],
                [
                    'class' => 'yii\grid\DataColumn',
                    'header' => 'Sisa Harus diBayar',
                    'value' => function ($model) {
                return ($model->invoice_value - $model->paid);
            },
                    'format' => 'number',
                    'footer' => number_format($jmlRemain),
                    'footerOptions' => ['style' => 'text-align:right; font-weight: bold;'],
                    'contentOptions' => ['style' => 'text-align:right;']
                ],
                [
                    'class' => 'yii\grid\DataColumn',
                    'header' => 'diBayar',
                    'value' => function ($model) {
                return Html::textInput('excpaid', '', ['style' => 'text-align:right']);
            },
                    'format' => 'raw'
                ],
            // 'invoice_type',
            ],
        ]);
        ?>
        <div class="box-footer">
            <?= Html::submitButton($payment->isNewRecord ? 'Create' : 'Update', ['class' => $payment->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    </div>
    <?php ActiveForm::end();
    ?>
</div>

