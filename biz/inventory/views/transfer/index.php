<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use biz\app\components\Helper;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var biz\purchase\models\PurchaseSearch $searchModel
 */
$this->title = 'Transfer';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="purchase-hdr-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="pull-right">
        <?= Html::a('', ['create'], ['class' => 'btn btn-default glyphicon glyphicon-plus', 'title' => 'Create New', 'style' => 'width:100%;']) ?>
    </div>


    <?php Pjax::begin(['formSelector' => 'form', 'enablePushState' => false]); ?>
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
            'nmStatus',
            [
                'class' => 'biz\app\components\ActionColumn',
                'template' => '{view} {update} {delete} {issue}',
                'buttons' => [
                    'issue' => function ($url, $model) {
                    if (Helper::checkAccess('issue', $model)) {
                        return Html::a('<span class="glyphicon glyphicon-open"></span>', $url, [
                                'title' => Yii::t('yii', 'Issue'),
                                'data-confirm' => Yii::t('yii', 'Are you sure you want to issue this item?'),
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
    <?php Pjax::end(); ?>
</div>
