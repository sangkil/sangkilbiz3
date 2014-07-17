<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use biz\master\models\Customer;

/**
 * @var yii\web\View $this
 * @var biz\models\Customer $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="customer-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="box box-primary">
        <div class="box-body">
            <?= $form->field($model, 'cd_customer')->textInput(['maxlength' => 13, 'style' => 'width:120px;']) ?>

            <?= $form->field($model, 'nm_customer')->textInput(['maxlength' => 64]) ?>

            <?= $form->field($model, 'contact_name')->textInput(['maxlength' => 64]) ?>

            <?= $form->field($model, 'contact_number')->textInput(['maxlength' => 64]) ?>

            <?= ''//$form->field($model, 'status')->dropDownList(StatusBehavior::statusList(Customer::className()), ['style' => 'width:200px;']); ?>

        </div>
        <div class="box-footer">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>

</div>
