<?php

use yii\helpers\Html;
use yii\grid\GridView;
use biz\purchase\models\Purchase;
use yii\widgets\LinkPager;
use yii\grid\DataColumn;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var biz\models\PurchaseSearch $searchModel
 */
$this->title = 'Purchase Hdrs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="purchase-hdr-index">
    <?php yii\widgets\Pjax::begin(['formSelector' => 'form', 'enablePushState' => false]); ?>
    <div class="col-lg-6" style="float: right;">
        <?php echo $this->render('_search', ['model' => $searchModel]); ?>
    </div>
    <div class="col-lg-12">
        <div class="box box-info">
            <?php
            echo GridView::widget([
                'dataProvider' => $dataProvider,
                'tableOptions' => ['class' => 'table table-striped'],
                'layout' => '{items}',
                //'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    'purchase_num',
                    'idSupplier.nm_supplier',
                    'idBranch.nm_branch',
                    'purchaseDate',
                    'nmStatus',
                    [
                        'class' => DataColumn::className(),
                        'label' => 'Status',
                        'value' => function ($model) {
                    $warnaStatus = 'label-warning';
                    switch ($model->status) {
                        case Purchase::STATUS_DRAFT:
                            $warnaStatus = 'label-warning';
                            break;
                        case Purchase::STATUS_RECEIVE:
                            $warnaStatus = 'label-success';
                            break;
                    }

                    return "<span class='label $warnaStatus'>{$model->nmStatus}</span>";
                },
                        'format' => 'raw'
                    ],
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template' => '{view} {update} {delete} {receive} {posting}',
                        'buttons' => [
                            'update' => function ($url, $model) {
                        return $model->status == Purchase::STATUS_DRAFT ? Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
                                    'title' => Yii::t('yii', 'Update'),
                                    'data-pjax' => '0',
                                ]) : '';
                    },
                            'delete' => function ($url, $model) {
                        return $model->status == Purchase::STATUS_DRAFT ? Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
                                    'title' => Yii::t('yii', 'Delete'),
                                    'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                                    'data-method' => 'post',
                                    'data-pjax' => '0',
                                ]) : '';
                    },
                            'receive' => function ($url, $model) {
                        return $model->status == Purchase::STATUS_DRAFT ? Html::a('<span class="glyphicon glyphicon-save"></span>', $url, [
                                    'title' => Yii::t('yii', 'Receive'),
                                    'data-confirm' => Yii::t('yii', 'Are you sure you want to Receive this item?'),
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
        <?php
        // display pagination
        echo LinkPager::widget([
            'pagination' => $dataProvider->pagination,
            'options' => ['class' => 'pagination pagination-sm no-margin']
        ]);
        yii\widgets\Pjax::end();
        ?>
    </div>
</div>
<?php
$js = "\$('#kecilin').click();";
$this->registerJs($js);
