<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model biz\inventory\models\StockOpname */

$this->title = 'Update Stock Opname: ' . ' ' . $model->opname_num;
$this->params['breadcrumbs'][] = ['label' => 'Stock Opnames', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->opname_num, 'url' => ['view', 'id' => $model->id_opname]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="stock-opname-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
