<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model biz\inventory\models\searchs\StockOpname */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="stock-opname-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_opname') ?>

    <?= $form->field($model, 'opname_num') ?>

    <?= $form->field($model, 'id_warehouse') ?>

    <?= $form->field($model, 'opname_date') ?>

    <?= $form->field($model, 'description') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'operator1') ?>

    <?php // echo $form->field($model, 'operator2') ?>

    <?php // echo $form->field($model, 'operator3') ?>

    <?php // echo $form->field($model, 'create_at') ?>

    <?php // echo $form->field($model, 'create_by') ?>

    <?php // echo $form->field($model, 'update_at') ?>

    <?php // echo $form->field($model, 'update_by') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
