<?php

/**
 * @var yii\web\View $this
 * @var biz\models\Warehouse $model
 */

$this->title = 'Create Warehouse';
$this->params['breadcrumbs'][] = ['label' => 'Warehouses', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="warehouse-create  col-lg-6">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
