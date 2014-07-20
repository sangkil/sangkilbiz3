<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model biz\inventory\models\StockOpname */

$this->title = 'Create Stock Opname';
$this->params['breadcrumbs'][] = ['label' => 'Stock Opnames', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="stock-opname-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
