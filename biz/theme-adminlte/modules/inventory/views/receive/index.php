<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use biz\app\components\Helper;
use yii\grid\DataColumn;
use biz\inventory\models\Transfer;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var biz\purchase\models\PurchaseSearch $searchModel
 */
$this->title = 'Receive';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="purchase-hdr-index">
    <div class="col-lg-4" style="float: right;">
        <?php echo $this->render('_search', ['model' => $searchModel]); ?>
    </div>
    <div class="col-lg-12">
        <?php //Pjax::begin(['formSelector' => 'form', 'enablePushState' => false]); ?>
        <div class="box box-danger">
            <div class="box-body no-padding">
                <?php
                echo GridView::widget([
                    'dataProvider' => $dataProvider,
                    'tableOptions' => ['class' => 'table table-striped'],
                    'layout' => '{items}',
                    //'filterModel' => $searchModel,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        'transfer_num',
                        'idWarehouseSource.nm_whse',
                        'idWarehouseDest.nm_whse',
                        'transferDate',
                        //'nmStatus',
                        [
                            'class' => DataColumn::className(),
                            'label' => 'Status',
                            'value' => function ($model) {
                        $warnaStatus = 'label-warning';
                        switch ($model->status) {
                            case Transfer::STATUS_DRAFT:
                                $warnaStatus = 'label-danger';
                                break;
                            case Transfer::STATUS_ISSUE:
                                $warnaStatus = 'label-warning';
                                break;
                            case Transfer::STATUS_DRAFT_RECEIVE:
                                $warnaStatus = 'label-info';
                                break;
                            case Transfer::STATUS_CONFIRM_REJECT:
                                $warnaStatus = 'label-info';
                                break;
                            case Transfer::STATUS_CONFIRM_APPROVE:
                                $warnaStatus = 'label-primary';
                                break;
                            case Transfer::STATUS_RECEIVE:
                                $warnaStatus = 'label-success';
                                break;
                        }

                        return "<span class='label $warnaStatus'>{$model->nmStatus}</span>";
                    },
                            'format' => 'raw'
                        ],
                        [
                            'class' => 'yii\grid\ActionColumn',
                            'template' => '{view} {update} {receive}',
                            'buttons' => [
                                'update' => function ($url, $model) {
                            $allowUpdate = [Transfer::STATUS_ISSUE, Transfer::STATUS_DRAFT_RECEIVE];

                            return in_array($model->status, $allowUpdate) ? Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
                                        'title' => Yii::t('yii', 'Update'),
                                        'data-pjax' => '0',
                                    ]) : '';
                        },
                                'receive' => function ($url, $model) {
                            $url = ['receive', 'id' => $model->id_transfer];

                            return $model->status == Transfer::STATUS_DRAFT_RECEIVE ? Html::a('<span class="glyphicon glyphicon-save"></span>', $url, [
                                        'title' => Yii::t('yii', 'Receive'),
                                        'data-confirm' => Yii::t('yii', 'Are you sure you want to receive this item?'),
                                        'data-method' => 'post',
                                        'data-pjax' => '0',
                                    ]) : '';
                        }
                            ]
                        ],
                    ],
                ]);
                ?>
            </div>
        </div>
        <?php
        // display pagination
        echo LinkPager::widget([
            'pagination' => $dataProvider->pagination,
            'options' => ['class' => 'pagination pagination-sm no-margin']
        ]);
        ?>
        <?php //Pjax::end(); ?>
    </div>

    <div class=" col-lg-12">
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
                        'transfer_num',
                        'idWarehouseSource.nm_whse',
                        'idWarehouseDest.nm_whse',
                        'transferDate',
                        'receiveDate',
                        //'nmStatus',
                        [
                            'class' => DataColumn::className(),
                            'label' => 'Status',
                            'value' => function ($model) {
                                $warnaStatus = 'label-warning';
                                switch ($model->status) {
                                    case Transfer::STATUS_DRAFT:
                                        $warnaStatus = 'label-danger';
                                        break;
                                    case Transfer::STATUS_ISSUE:
                                        $warnaStatus = 'label-success';
                                        break;
                                    case Transfer::STATUS_CONFIRM:
                                        $warnaStatus = 'label-info';
                                        break;
                                    case Transfer::STATUS_CONFIRM_APPROVE:
                                        $warnaStatus = 'label-info';
                                        break;
                                    case Transfer::STATUS_CONFIRM_REJECT:
                                        $warnaStatus = 'label-danger';
                                        break;
                                    case Transfer::STATUS_RECEIVE:
                                        $warnaStatus = 'label-primary';
                                        break;
                                }

                                return "<span class='label $warnaStatus'>{$model->nmStatus}</span>";
                            },
                            'format' => 'raw'
                        ],
                        [
                            'class' => 'biz\app\components\ActionColumn',
                            'template' => '{view} {update} {receive}',
                            'buttons' => [
                                'receive' => function ($url, $model) {
                            if (Helper::checkAccess('receive', $model)) {
                                return Html::a('<span class="glyphicon glyphicon-save"></span>', $url, [
                                            'title' => Yii::t('yii', 'Receive'),
                                            'data-confirm' => Yii::t('yii', 'Are you sure you want to receive this item?'),
                                            'data-method' => 'post',
                                            'data-pjax' => '0',
                                ]);
                            }
                        }
                            ]
                        ],
                    ],
                ]);
                ?>
            </div>
        </div>
        <?php Pjax::end(); ?>
    </div>
</div>
