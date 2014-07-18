<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\grid\GridView;
use yii\data\ArrayDataProvider;
use yii\widgets\DetailView;
use biz\inventory\models\TransferNotice;
use biz\app\components\Helper as AppHelper;

/* @var $this yii\web\View */
/* @var $model biz\inventory\models\TransferNotice */
/* @var $form yii\widgets\ActiveForm */
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
<div class="purchase-hdr-view">
    <?php
    $models = $model->transferNoticeDtls;
    $models[] = $model;
    echo $form->errorSummary($models);
    ?>

    <div class="col-lg-4" style="padding-left: 0px;">
        <div class="box box-primary">
            <div class="box-body no-padding">
                <?php

                function cLabel($status, $nm_status) {
                    $warnaStatus = 'label-warning';
                    switch ($status) {
                        case TransferNotice::STATUS_CREATE:
                            $warnaStatus = 'label-danger';
                            break;
                        case TransferNotice::STATUS_UPDATE:
                            $warnaStatus = 'label-success';
                            break;
                        case TransferNotice::STATUS_APPROVE:
                            $warnaStatus = 'label-primary';
                            break;
                    }
                    return "<span class='label $warnaStatus'>{$nm_status}</span>";
                }

                echo DetailView::widget([
                    'options' => ['class' => 'table table-striped detail-view', 'style' => 'padding:0px;'],
                    'model' => $model,
                    'attributes' => [
                        'idTransfer.transfer_num',
                        'idTransfer.idWarehouseSource.nm_whse',
                        'idTransfer.idWarehouseDest.nm_whse',
                        'noticeDate',
                        [// the owner name of the model
                            'label' => 'Status',
                            'value' => cLabel($model->status, $model->nmStatus),
                            'format' => 'raw'
                        ],
                    ],
                ]);
                ?>                
            </div>
            <div class="box-footer">
                <?php
                echo Html::activeHiddenInput($model, 'status', ['value' => TransferNotice::STATUS_UPDATE]);
                if (AppHelper::checkAccess('update', $model)) {
                    echo Html::submitButton('Update', ['class' => 'btn btn-success']);
                }
                ?>
            </div>
        </div>
    </div>
    <div class="col-lg-8">
        <div class="box box-info">
            <div class="box-body no-padding">
                <?php
                echo GridView::widget([
                    'tableOptions' => ['class' => 'table table-striped'],
                    'layout' => '{items}{pager}',
                    'dataProvider' => new ArrayDataProvider([
                        'allModels' => $model->transferNoticeDtls,
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
    </div>
</div>
<?php
ActiveForm::end();
