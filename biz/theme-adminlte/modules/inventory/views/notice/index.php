<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use biz\inventory\models\TransferNotice;
use yii\grid\DataColumn;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var biz\inventory\models\searchs\TransferNotice $searchModel
 */
$this->title = 'Transfer Notices';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="transfer-notice-index col-lg-12">

    <?php Pjax::begin(['formSelector' => 'form', 'enablePushState' => false]); ?>
    <div class="box box-info">
        <div class="box-body no-padding">
            <?php
            echo GridView::widget([
                'dataProvider' => $dataProvider,
                'tableOptions' => ['class' => 'table table-striped'],
                'layout' => '{items}{pager}',
                //'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    'idTransfer.transfer_num',
                    'idTransfer.idWarehouseSource.nm_whse',
                    'idTransfer.idWarehouseDest.nm_whse',
                    'noticeDate',
                    //'nmStatus',
                    [
                        'class' => DataColumn::className(),
                        'label' => 'Status',
                        'value' => function ($model) {
                            $warnaStatus = 'label-warning';
                            switch ($model->status) {
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
                            return "<span class='label $warnaStatus'>{$model->nmStatus}</span>";
                        },
                        'format' => 'raw'
                    ],
                    [
                        'class' => 'biz\app\components\ActionColumn',
                        'template' => '{view} {update}',
                    ],
                ],
            ]);
            ?>
        </div>
    </div>    
    <?php Pjax::end(); ?>
</div>
