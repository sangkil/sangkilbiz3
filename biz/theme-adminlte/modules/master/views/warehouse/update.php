<?php

/**
 * @var yii\web\View $this
 * @var biz\models\Warehouse $model
 */

$this->title = 'Update Warehouse: ' . ' ' . $model->id_warehouse;
$this->params['breadcrumbs'][] = ['label' => 'Warehouses', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_warehouse, 'url' => ['view', 'id' => $model->id_warehouse]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="warehouse-update col-lg-8">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
