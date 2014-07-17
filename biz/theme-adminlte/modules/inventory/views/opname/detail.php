<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model biz\inventory\models\StockOpname */

$this->title = 'Detail of: ' . ' ' . $model->opname_num;
$this->params['breadcrumbs'][] = ['label' => 'Stock Opnames', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->opname_num, 'url' => ['view', 'id' => $model->id_opname]];
$this->params['breadcrumbs'][] = 'Detail';
?>
<div class="stock-opname-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'idProduct.nm_product',
            'qty',

//            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    
</div>
