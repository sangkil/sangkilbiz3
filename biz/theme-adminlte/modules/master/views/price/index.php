<?php

use yii\helpers\Html;
use yii\grid\GridView;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var biz\master\models\PriceSearch $searchModel
 */
$this->title = 'Prices';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="price-index">
    <div class="col-lg-12" style="text-align: right; padding-bottom: 10px;">
        <?= Html::a('', ['create'], ['class' => 'btn btn-warning btn-sm fa fa-plus', 'title' => 'New Supplier']) ?>
    </div>  
    <div class=" col-lg-12">
        <div class="box box-info">
            <div class="box-body no-padding">
                <?=
                GridView::widget([
                    'dataProvider' => $dataProvider,
                    'tableOptions' => ['class' => 'table table-striped'],
                    'layout' => '{items}{pager}',
                    //'filterModel' => $searchModel,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        //'id_product',
                        'idProduct.cd_product',
                        'idProduct.nm_product',
                        //'id_price_category',
                        'idPriceCategory.nm_price_category',
                        'id_uom',
                        'price',
                        'create_at',
                        // 'create_by',
                        // 'update_at',
                        // 'update_by',
                        ['class' => 'biz\app\components\ActionColumn'],
                    ],
                ]);
                ?>
            </div>
        </div>
    </div>
</div>



</div>
