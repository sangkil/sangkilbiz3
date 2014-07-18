<?php

use yii\helpers\Html;
use yii\grid\GridView;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var biz\models\SupplierSearch $searchModel
 */
$this->title = 'Suppliers';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="supplier-index">
    <div class="col-lg-12" style="text-align: right; padding-bottom: 10px;">
        <?= Html::a('', ['create'], ['class' => 'btn btn-warning btn-sm fa fa-plus', 'title' => 'New Supplier']) ?>
    </div>
    <div class=" col-lg-12">
        <div class="box box-info">
            <div class="box-body no-padding">
                <?php
                yii\widgets\Pjax::begin([
                    'enablePushState' => false,
                ])
                ?>
                <?php
                echo GridView::widget([
                    'dataProvider' => $dataProvider,
                    'tableOptions' => ['class' => 'table table-striped'],
                    'layout' => '{items}',
                    //'filterModel' => $searchModel,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        //'id_supplier',
                        'cd_supplier',
                        'nm_supplier',
                        'create_at',
                        'create_by',
                        // 'update_at',
                        // 'update_by',
                        ['class' => 'yii\grid\ActionColumn'],
                    ],
                ]);
                ?>
                <?php yii\widgets\Pjax::end() ?>

            </div>
        </div>
    </div>
</div>
