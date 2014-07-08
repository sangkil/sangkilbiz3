<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\grid\GridView;
use yii\data\ArrayDataProvider;
use yii\widgets\DetailView;
use biz\models\TransferNotice;

/**
 * @var yii\web\View $this
 * @var biz\models\TransferNotice $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<?php
$form = ActiveForm::begin([
            'fieldConfig' => [
                'template' => "{input}"
            ]
        ])
?>
<?php
$renderField = function ($model, $key) use($form) {
    return $form->field($model, "[$key]qty_approve")->textInput(['style' => 'width:80px;']);
}
?>
<div class="col-lg-3" style="padding-left: 0px;">
    <div class="box box-danger">
        <div class="box-body no-padding">
            <?php
            echo DetailView::widget([
                'options' => ['class' => 'table table-striped detail-view', 'style' => 'padding:0px;'],
                'model' => $model,
                'attributes' => [
                    'idTransfer.transfer_num',
                    'idTransfer.idWarehouseSource.nm_whse',
                    'idTransfer.idWarehouseDest.nm_whse',
                    'noticeDate',
                ],
            ]);
            ?>
        </div>
        <div class="box-footer">
            <?php
            if ($model->status == TransferNotice::STATUS_CREATE || $model->status == TransferNotice::STATUS_UPDATE) {
                echo Html::submitButton('Update', ['class' => 'btn btn-success']);
            }
            ?>
        </div>
    </div>
</div>
<div class="purchase-hdr-view col-lg-9">
    <div class="box box-info">
        <div class="box-body no-padding">
            <?php
            echo GridView::widget([
                'tableOptions' => ['class' => 'table table-striped'],
                'layout' => '{items}{pager}',
                'dataProvider' => new ArrayDataProvider([
                    'allModels' => $details,
                    'sort' => false,
                    'pagination' => false,
                        ]),
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    'idProduct.nm_product',
                    'transferDtl.transfer_qty_send:text:Qty Send',
                    'transferDtl.transfer_qty_receive:text:Qty Receive',
                    'qty_notice',
                    [
                        'label' => 'Qty Approve',
                        'format' => 'raw',
                        'content' => $renderField
                    ],
                    'idUom.nm_uom',
                ]
            ]);
            ?>
        </div>
    </div>
    <?php
    ActiveForm::end();
    