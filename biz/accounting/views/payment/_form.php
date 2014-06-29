<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model biz\accounting\models\Payment */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="payment-form">
    <?php
    $form = ActiveForm::begin([
            'id' => 'payment-form'
    ]);
    ?>
    <?php
    $models = $details;
    $models[] = $model;
    echo $form->errorSummary($model);
    ?>
    <div class="box-body">
        <table border="0" style="width: 100%;">
            <tbody>
                <tr>
                    <td>
                        <?= $form->field($model, 'payment_num')->textInput(['style' => 'width:150px;']) ?>
                    </td>
                    <td>
                        <?= $form->field($model, 'payment_type')->dropDownList(['Cash', 'Bank BNI', 'Bank Mandiri'], ['style' => 'width:150px;']) ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <?=
                        $form->field($model, 'paymentDate')->widget('yii\jui\DatePicker', [
                            'options' => ['class' => 'form-control', 'style' => 'width:150px'],
                            'clientOptions' => [
                                'dateFormat' => 'dd-mm-yy'
                            ],
                        ]);
                        ?>
                    </td>
                    <td>
                        <?=
                        $form->field($model, 'totalPaid')->textInput([
                            'style' => 'width:200px;text-align:right',
                            'id' => 'total-paid',
                            'readonly'
                        ])
                        ?>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>           
    <?php
    echo GridView::widget([
        'id' => 'inv_grid',
        'dataProvider' => Yii::createObject([
            'class' => 'yii\data\ArrayDataProvider',
            'allModels' => $details,
        ]),
        'showFooter' => true, 'tableOptions' => ['class' => 'table table-striped'],
        'layout' => '{items}',
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            //'id_invoice',
            'idInvoice.inv_num',
//            'invoiceDtl.idPurchase.purchase_num',
//            'idSupplier.nm_supplier',
            //'invDate',
            'idInvoice.dueDate',
            //'id_vendor',
            ['class' => 'yii\grid\DataColumn',
                'header' => 'Nilai Invoice',
                'attribute' => 'idInvoice.inv_value',
                'format' => 'number',
                'footer' => number_format($jmlInv),
                'footerOptions' => ['style' => 'text-align:right; font-weight: bold;'],
                'contentOptions' => ['style' => 'text-align:right;']],
            ['class' => 'yii\grid\DataColumn',
                'header' => 'Dibayar',
                'attribute' => 'idInvoice.paid',
                'format' => 'number',
                'footer' => number_format($jmlPaid),
                'footerOptions' => ['style' => 'text-align:right; font-weight: bold;'],
                'contentOptions' => ['style' => 'text-align:right;']],
            [
                'class' => 'yii\grid\DataColumn',
                'header' => 'Sisa Harus diBayar',
                'attribute' => 'idInvoice.sisaBayar',
                'format' => 'number',
                'footer' => number_format($jmlRemain),
                'footerOptions' => ['style' => 'text-align:right; font-weight: bold;'],
                'contentOptions' => ['style' => 'text-align:right;']
            ],
            [
                'class' => 'yii\grid\DataColumn',
                'header' => 'Dibayar',
                'value' => function ($model, $key, $index) {
                return Html::activeTextInput($model, "[$index]payVal", [
                        'style' => 'text-align:right',
                        'class' => 'pay_val',
                        'value' => number_format($model->idInvoice->sisaBayar)
                    ]) .
                    Html::activeHiddenInput($model, "[$index]id_invoice");
            },
                'format' => 'raw'
            ],
        ],
    ]);
    ?>
    <div class="box-footer">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
<?php
$js = <<<JS
yii.numeric.format(\$('#payment-form'),'input.pay_val');
    
function hitungTotal(){
    var total=0;
    \$('#payment-form input.pay_val').each(function(){
        total += numeral().unformat(this.value);
    });
    \$('#total-paid').val(numeral(total).format('0,0'));
}
hitungTotal();
\$('#payment-form')
    .off('change.biz','input.pay_val')
    .on('change.biz','input.pay_val',hitungTotal);
JS;
biz\app\assets\BizAsset::register($this);
$this->registerJs($js);
