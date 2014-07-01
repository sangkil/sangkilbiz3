<?php

use yii\helpers\Html;
use yii\grid\GridView;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var biz\models\searchs\AccPeriode $searchModel
 */
$this->title = 'Acc Periodes';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="acc-periode-index col-lg-6">
    <div class="box box-primary">
        <div class="box-body no-padding">
            <div class="pull-right" style="padding: 10px; padding-right: 15px;" >
                <?= Html::a('', ['create'], ['class' => 'fa fa-plus', 'title' => 'New Product', 'style' => 'width:100%;']) ?>
            </div>
            <?=
            GridView::widget([
                'dataProvider' => $dataProvider,
                'tableOptions' => ['class' => 'table table-striped'],
                //'filterModel' => $searchModel,
                'layout' => '{items}',
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    //'id_periode',
                    'nm_periode',
                    'date_from',
                    'date_to',
                    'status',
                    // 'create_at',
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
