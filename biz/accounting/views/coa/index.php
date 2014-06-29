<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var biz\accounting\models\\CoaSearch $searchModel
 */
$this->title = 'Coas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="coa-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php // echo $this->render('_search', ['model' => $searchModel]);  ?>

    <div class="pull-right">
        <?= Html::a('', ['create'], ['class' => 'btn btn-default glyphicon glyphicon-plus', 'title' => 'Create New', 'style' => 'width:100%;']) ?>
    </div>

    <?php Pjax::begin(['enablePushState' => false]); ?>
    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'tableOptions' => ['class' => 'table table-striped'],
        'layout' => '{items}{pager}',
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            //'id_coa',
            'cd_account',
            'nm_account',
            'coa_type',
            'nmCoaType',
            'normal_balance',
            ['class' => 'biz\app\components\ActionColumn'],
        ],
    ]);
    ?>
    <?php Pjax::end(); ?>
</div>
