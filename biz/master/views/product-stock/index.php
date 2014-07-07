<?php

use yii\helpers\Html;
use yii\grid\GridView;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var biz\master\models\ProductStockSearch $searchModel
 */

$this->title = 'Product Stocks';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-stock-index">

	<h1><?= Html::encode($this->title) ?></h1>

	<?php // echo $this->render('_search', ['model' => $searchModel]); ?>

	<?= GridView::widget([
		'dataProvider' => $dataProvider,
		'tableOptions' => ['class' => 'table table-striped'],
        'layout' => '{items}{pager}',
        //'filterModel' => $searchModel,
		'columns' => [
			['class' => 'yii\grid\SerialColumn'],

			'idWarehouse.nm_whse',
			'idProduct.nm_product',
			'qty_stock',
			'idUom.nm_uom',
			// 'qty_stock',
			// 'status_closing',
			// 'create_at',
			// 'create_by',
			// 'update_at',
			// 'update_by',

			['class' => 'biz\app\components\ActionColumn'],
		],
	]); ?>

</div>
