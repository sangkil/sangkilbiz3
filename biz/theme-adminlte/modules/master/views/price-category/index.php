<?php

use yii\helpers\Html;
use yii\grid\GridView;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var biz\master\models\PriceCategorySearch $searchModel
 */
$this->title = 'Price Categories';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="price-category-index">
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
                        //'id_price_category',
                        'nm_price_category',
                        'formula',
                        'create_by',
                        'update_at',
                        // 'update_by',
                        // 'create_at',
                        ['class' => 'biz\app\components\ActionColumn'],
                    ],
                ]);
                ?>
            </div>
        </div>
    </div>


</div>
