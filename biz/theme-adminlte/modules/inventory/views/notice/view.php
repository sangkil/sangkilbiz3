<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use biz\inventory\models\TransferNotice;
use yii\data\ActiveDataProvider;

/**
 * @var yii\web\View $this
 * @var TransferNotice $model
 */
$this->title = 'Transfer Note #' . $model->idTransfer->transfer_num;
$this->params['breadcrumbs'][] = ['label' => 'Transfer Notices', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="col-lg-4" style="padding-left: 0px;">
    <div class="box box-primary">
        <div class="box-body no-padding">
            <?php
            function cLabel($status,$nm_status)
            {
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
                        'value' => cLabel($model->status,$model->nmStatus),
                        'format'=>'raw'
                    ],
            ]]);
            ?>
        </div>
        <div class="box-footer">
            <?php
            if ($model->status == TransferNotice::STATUS_CREATE || $model->status == TransferNotice::STATUS_UPDATE) {
                echo Html::a('Update', ['update', 'id' => $model->id_transfer], ['class' => 'btn btn-success']);
            }
            ?>
            <?php
            if ($model->status == TransferNotice::STATUS_UPDATE) {
                echo Html::a('Approve', ['approve', 'id' => $model->id_transfer], [
                    'class' => 'btn btn-primary',
                    'data-confirm' => Yii::t('app', 'Are you sure to approve this item?'),
                    'data-method' => 'post',
                ]);
            }
            ?>
        </div>
    </div>
</div>
<div class="purchase-hdr-view col-lg-8">
    <div class="box box-info">
        <div class="box-body no-padding">
            <?php
            echo GridView::widget([
                'tableOptions' => ['class' => 'table table-striped'],
                'layout' => '{items}{pager}',
                'dataProvider' => new ActiveDataProvider([
                    'query' => $model->getTransferNoticeDtls()->with('transferDtl'),
                    'sort' => false,
                    'pagination' => false,
                        ]),
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    'idProduct.nm_product',
                    'transferDtl.transfer_qty_send:text:Qty Send',
                    'transferDtl.transfer_qty_receive:text:Qty Receive',
                    'qty_notice',
                    'qty_approve',
                    'idUom.nm_uom',
                ]
            ]);
            ?>
        </div>
    </div>

</div>
