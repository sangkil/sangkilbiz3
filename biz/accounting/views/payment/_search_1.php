<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var biz\models\searchs\Invoice $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="invoice-hdr-search">
    <div class="panel panel-danger">
        <?php
        $form = ActiveForm::begin([
                    'action' => ['index'],
                    'method' => 'get',
        ]);
        ?>
        <div class="panel-body">
            <?= $form->field($model, 'id_invoice') ?>

            <?= $form->field($model, 'invoice_num') ?>

            <?= $form->field($model, 'invoice_type') ?>

            <?= $form->field($model, 'invoice_date') ?>

            <?= $form->field($model, 'due_date') ?>

            <?= $form->field($model, 'id_vendor') ?>

            <?php // echo $form->field($model, 'invoice_value') ?>

            <?php // echo $form->field($model, 'status') ?>

            <?php // echo $form->field($model, 'create_at') ?>

            <?php // echo $form->field($model, 'create_by') ?>

            <?php // echo $form->field($model, 'update_at') ?>

            <?php // echo $form->field($model, 'update_by')  ?>
        </div>
        <div class="panel-footer form-group">
            <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
            <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>
