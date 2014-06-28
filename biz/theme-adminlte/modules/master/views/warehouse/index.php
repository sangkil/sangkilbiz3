<?php

use yii\helpers\Html;
use yii\grid\GridView;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var biz\models\WarehouseSearch $searchModel
 */
$this->title = 'Warehouses';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="warehouse-index">

    <div class="col-lg-12" style="text-align: right; padding-bottom: 10px;">
        <?= Html::a('', ['create'], ['class' => 'btn btn-warning btn-sm fa fa-plus', 'title' => 'New Warehouse']) ?>
    </div>

    <div class=" col-lg-12">
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
                        'id_warehouse',
                        'cd_whse',
                        'nm_whse',
                        'create_date',
                        'create_by',
                        // 'update_date',
                        // 'update_by',
                        ['class' => 'biz\app\components\ActionColumn'],
                    ],
                ]);
                ?>

            </div>
        </div>
    </div>
</div>
