<?php

use yii\helpers\Html;
use yii\grid\GridView;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var biz\master\models\searchs\ProductGroup $searchModel
 */
$this->title = 'Product Groups';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-group-index">
    <div class="col-lg-12" style="text-align: right; padding-bottom: 10px;">
        <?= Html::a('', ['create'], ['class' => 'btn btn-warning btn-sm fa fa-plus', 'title' => 'New Supplier']) ?>
    </div>
    <div class=" col-lg-12">
        <div class="box box-info">
            <div class="box-body no-padding">
                <?=
                GridView::widget([
                    'dataProvider' => $dataProvider,
                    //'filterModel' => $searchModel,
                    'tableOptions' => ['class' => 'table table-striped'],
                    'layout'=>'{items}{pager}',
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        //'id_group',
                        'cd_group',
                        'nm_group',
                        'create_at',
                        'create_by',
                        // 'update_at',
                        // 'update_by',
                        ['class' => 'yii\grid\ActionColumn'],
                    ],
                ]);
                ?>
            </div>
        </div>
    </div>
</div>
