<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var biz\models\Customer $model
 */

$this->title = 'Update Customer: ' . $model->id_customer;
$this->params['breadcrumbs'][] = ['label' => 'Customers', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_customer, 'url' => ['view', 'id' => $model->id_customer]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="customer-update col-lg-8">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
