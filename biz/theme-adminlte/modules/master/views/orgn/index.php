<?php

use yii\helpers\Html;
use yii\grid\GridView;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var biz\models\OrgnSearch $searchModel
 */
$this->title = 'Orgns';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="orgn-index">
    <div class="col-lg-12" style="text-align: right; padding-bottom: 10px;">
        <?= Html::a('', ['create'], ['class' => 'btn btn-warning btn-sm fa fa-plus', 'title' => 'New Supplier']) ?>
    </div>
    <div class=" col-lg-12">
        <div class="box box-info">
            <?php
            echo GridView::widget([
                'dataProvider' => $dataProvider,
                'tableOptions' => ['class' => 'table table-striped'],
                'layout' => '{items}',
                //'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    //'id_orgn',
                    'cd_orgn',
                    'nm_orgn',
                    'create_at',
                    'create_by',
                    // 'update_at',
                    // 'update_by',
                    ['class' => 'biz\app\components\ActionColumn'],
                ],
            ]);
            ?>
        </div>
    </div>
</div>