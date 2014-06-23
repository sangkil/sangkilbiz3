<?php

use yii\helpers\Html;
use yii\grid\GridView;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var biz\models\\EntriSheetSearch $searchModel
 */

$this->title = 'Entri Sheets';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="entri-sheet-index">
  <div class="box box-danger">
        <div class="box-body no-padding"><div class="pull-right" style="padding: 10px;" >
                <?= Html::a('', ['create'], ['class' => 'fa fa-plus', 'title' => 'New Product', 'style' => 'width:100%;']) ?>
            </div>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'tableOptions' => ['class' => 'table table-striped'],
        'layout' => '{items}',
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            //'id_esheet',
            'cd_esheet',
            'nm_esheet',
            'create_date',
            'create_by',
            // 'update_date',
            // 'update_by',

            ['class' => 'biz\master\components\ActionColumn'],
        ],
    ]); ?>

        </div>
    </div>
</div>
