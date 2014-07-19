<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var biz\models\Supplier $model
 */

$this->title = 'Update Supplier: ' . ' ' . $model->id_supplier;
$this->params['breadcrumbs'][] = ['label' => 'Suppliers', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_supplier, 'url' => ['view', 'id' => $model->id_supplier]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="supplier-update col-lg-8">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
