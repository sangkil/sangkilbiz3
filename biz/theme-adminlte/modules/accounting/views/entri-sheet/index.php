<?php

use yii\helpers\Html;
use yii\grid\GridView;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var biz\accounting\models\\EntriSheetSearch $searchModel
 */
$this->title = 'Entri Sheets';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="entri-sheet-index">
    <div class="box box-danger">
        <div class="box-header">
            <h3 class="box-title">Coas</h3>
            <div class="pull-right" style="padding: 20px;" >
                <?= Html::a('', ['create'], ['class' => 'fa fa-plus', 'title' => 'New Entri-Sheet', 'style' => 'width:100%;']) ?>
            </div>
        </div>
        <div class="box-body no-padding">
            <?=
            GridView::widget([
                'dataProvider' => $dataProvider,
                'tableOptions' => ['class' => 'table table-striped'],
                'layout' => '{items}{pager}',
                //'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    //'id_esheet',
                    'cd_esheet',
                    'nm_esheet',
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
