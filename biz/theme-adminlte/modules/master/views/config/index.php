<?php

use yii\helpers\Html;
use yii\grid\GridView;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var biz\master\models\GlobalConfigSearch $searchModel
 */
$this->title = 'Global Configs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="global-config-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]);  ?>

    <div class="col-lg-12" style="text-align: right; padding-bottom: 10px;">
        <?= Html::a('', ['create'], ['class' => 'btn btn-warning btn-sm fa fa-plus', 'title' => 'New Warehouse']) ?>
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
                        'group',
                        'name',
                        'value',
                        'description',
                        ['class' => 'yii\grid\ActionColumn'],
                    ],
                ]);
                ?>
            </div>
        </div>
    </div>
</div>
