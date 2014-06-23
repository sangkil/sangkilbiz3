<?php

use yii\helpers\Html;
use yii\grid\GridView;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var biz\models\\CoaSearch $searchModel
 */
$this->title = 'Coas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="coa-index">
    <div class="box box-danger">
        <div class="box-header">
            <h3 class="box-title">Coas</h3>
            <div class="pull-right" style="padding: 20px;" >
                <?= Html::a('', ['create'], ['class' => 'fa fa-plus', 'title' => 'New Product', 'style' => 'width:100%;']) ?>
            </div>
        </div>
        <div class="box-body no-padding">

    <?php
    \yii\widgets\Pjax::begin(['enablePushState' => false]);
    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'tableOptions' => ['class' => 'table table-striped'],
        'layout' => '{items}{pager}',
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            //'id_coa',
            'cd_account',
            'nm_account',
            //'coa_type',
            'nmCoaType',
            'normal_balance',
            'createDate',
            //'id_coa_parent',
            //'create_date',
            // 'create_by',
            // 'update_date',
            // 'update_by',
            ['class' => 'biz\master\components\ActionColumn'],
        ],
    ]);
    \yii\widgets\Pjax::end();
    ?>


        </div>
    </div>
</div>
