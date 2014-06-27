<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model biz\accounting\models\Payment */

$this->title = 'Update Payment: ' . ' ' . $model->id_payment;
$this->params['breadcrumbs'][] = ['label' => 'Payments', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_payment, 'url' => ['view', 'id' => $model->id_payment]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="payment-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
