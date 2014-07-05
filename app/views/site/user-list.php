<?php

use yii\helpers\Html;
use yii\grid\GridView;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var biz\master\models\ProductSearch $searchModel
 */
$this->title = 'User List';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-list">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php //echo $this->render('_search', ['model' => $searchModel]);  ?>

    <div class="pull-right">
        <?= Html::a('', ['signup'], ['class' => 'btn btn-default glyphicon glyphicon-plus', 'title' => 'SignUp', 'style' => 'width:100%;']) ?>
    </div>

    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'tableOptions' => ['class' => 'table table-striped'],
        'layout' => '{items}{pager}',
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'username',
            'email',
            //'role',
            //'status',
            //'created_at',
            //'updated_at'
        ],
    ]);
    ?>
</div>
