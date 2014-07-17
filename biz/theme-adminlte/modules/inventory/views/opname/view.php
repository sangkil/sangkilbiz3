<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model biz\inventory\models\StockOpname */

$this->title = $model->opname_num;
$this->params['breadcrumbs'][] = ['label' => 'Stock Opnames', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="stock-opname-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id_opname], ['class' => 'btn btn-primary']) ?>
        <?=
        Html::a('Delete', ['delete', 'id' => $model->id_opname], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ])
        ?>
    </p>

    <?=
    DetailView::widget([
        'model' => $model,
        'attributes' => [
            'opname_num',
            'idWarehouse.nm_whse',
            'opnameDate',
            'description',
            'nmStatus',
            'operator',
            [
                'label' => 'Detail',
                'value' => Html::a('link',['detail', 'id' => $model->id_opname]),
                'format' => 'raw'
            ]
        ],
    ])
    ?>

</div>
