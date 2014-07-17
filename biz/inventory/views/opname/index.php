<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel biz\inventory\models\searchs\StockOpname */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Stock Opnames';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="stock-opname-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Stock Opname', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'opname_num',
            [
                'attribute'=>'id_warehouse',
                'value'=>'idWarehouse.nm_whse'
            ],
            'opnameDate',
            'description',
            'nmStatus',
            'operator',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
