<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var biz\models\searchs\InvoiceHdr $model
 * @var yii\widgets\ActiveForm $form
 */
?>
<div class="invoice-hdr-form">
    <?php $form = ActiveForm::begin(); ?>
    <div class="col-lg-6">
        <?= $form->field($model, 'payment_num')->textInput() ?>

        <?= $form->field($model, 'payment_type')->textInput() ?>
    </div>
    <div class="col-lg-6">        
        <?= $form->field($model, 'payment_date')->textInput() ?>
    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>