<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel biz\master\models\searchs\ProductUom */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Product Uoms';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-uom-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Product Uom', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id_product',
            'id_uom',
            'isi',
            'create_at',
            'create_by',
            // 'update_at',
            // 'update_by',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
