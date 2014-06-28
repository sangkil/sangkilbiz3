<?php

use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\widgets\LinkPager;
use biz\models\TransferNotice;
use yii\grid\DataColumn;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var biz\models\searchs\TransferNotice $searchModel
 */
$this->title = 'Transfer Notices';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="transfer-notice-index">    
    <div class="col-lg-4" style="float: right;">
        <?php echo $this->render('_search', ['model' => $searchModel]); ?> 
    </div>
    <div class="col-lg-12">
        <?php //Pjax::begin(['formSelector' => 'form', 'enablePushState' => false]); ?>
        <div class="box box-info">
            <div class="box-body no-padding">
                <?php
                echo GridView::widget([
                    'dataProvider' => $dataProvider,
                    'tableOptions' => ['class' => 'table table-striped'],
                    'layout' => '{items}',
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
                                $warnaStatus = 'label-warning';
                                break;
                            case TransferNotice::STATUS_APPROVE:
                                $warnaStatus = 'label-success';
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

