<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel biz\accounting\models\searchs\Payment */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Payments';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="payment-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Payment', ['list-invoice'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'payment_num',
            'payment_type',
            'paymentDate',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
