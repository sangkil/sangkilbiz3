<?php

use yii\helpers\Html;
use yii\grid\GridView;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var biz\accounting\models\searchs\Invoice $searchModel
 */

$this->title = 'Invoice Hdrs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="invoice-hdr-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Invoice Hdr', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id_invoice',
            'invoice_num',
            'invoice_type',
            'invoice_date',
            'due_date',
            // 'id_vendor',
            // 'invoice_value',
            // 'status',
            // 'create_at',
            // 'create_by',
            // 'update_at',
            // 'update_by',

            ['class' => 'biz\app\components\ActionColumn'],
        ],
    ]); ?>

</div>
