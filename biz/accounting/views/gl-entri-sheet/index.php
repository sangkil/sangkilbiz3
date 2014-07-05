<?php

use yii\helpers\Html;
use yii\grid\GridView;

/**
 * @var yii\web\View $this
 * @var biz\accounting\models\searchs\GlEntriSheet $searchModel
 * @var yii\data\ActiveDataProvider $dataProvider
 */

$this->title = 'Gl Headers';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gl-header-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Gl Header', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'glDate',
            'gl_num',
            'idBranch.nm_branch',
             'description',

            ['class' => 'biz\app\components\ActionColumn'],
        ],
    ]); ?>

</div>
