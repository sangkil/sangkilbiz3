<?php

use yii\helpers\Html;
use yii\grid\GridView;
use biz\models\TransferHdr;
use yii\widgets\LinkPager;
use yii\widgets\Pjax;
use yii\grid\DataColumn;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var biz\purchase\models\PurchaseHdrSearch $searchModel
 */
$this->title = 'Inventory Transfer';
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
                            case TransferHdr::STATUS_DRAFT:
                                $warnaStatus = 'label-danger';
                                break;
                            case TransferHdr::STATUS_ISSUE:
                                $warnaStatus = 'label-warning';
                                break;
                            case TransferHdr::STATUS_DRAFT_RECEIVE:
                                $warnaStatus = 'label-info';
                                break;
                            case TransferHdr::STATUS_CONFIRM_REJECT:
                                $warnaStatus = 'label-info';
                                break;
                            case TransferHdr::STATUS_CONFIRM_APPROVE:
                                $warnaStatus = 'label-primary';
                                break;
                            case TransferHdr::STATUS_RECEIVE:
                                $warnaStatus = 'label-success';
                                break;
                        }
                        return "<span class='label $warnaStatus'>{$model->nmStatus}</span>";
                    },
                            'format' => 'raw'
                        ],
                        [
                            'class' => 'biz\app\components\ActionColumn',
                            'template' => '{view} {update} {delete} {issue}',
                            'buttons' => [
                                'update' => function ($url, $model) {
                            return $model->status == TransferHdr::STATUS_DRAFT ? Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
                                        'title' => Yii::t('yii', 'Update'),
                                        'data-pjax' => '0',
                                    ]) : '';
                        },
                                'delete' => function ($url, $model) {
                            return $model->status == TransferHdr::STATUS_DRAFT ? Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
                                        'title' => Yii::t('yii', 'Delete'),
                                        'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                                        'data-method' => 'post',
                                        'data-pjax' => '0',
                                    ]) : '';
                        },
                                'issue' => function ($url, $model) {
                            return $model->status == TransferHdr::STATUS_DRAFT ? Html::a('<span class="glyphicon glyphicon-save"></span>', $url, [
                                        'title' => Yii::t('yii', 'Issue'),
                                        'data-confirm' => Yii::t('yii', 'Are you sure you want to issue this item?'),
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
        //Pjax::end();
        ?>
    </div>
</div>
<?php
$js = "\$('#kecilin').click();";
$this->registerJs($js);