<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;

/* @var $this yii\web\View */
/* @var $model biz\accounting\models\AccPeriode */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="acc-periode-form">

    <?php $form = ActiveForm::begin(); ?>
    <?= $form->errorSummary($model) ?>
    <?= $form->field($model, 'nm_periode')->textInput(['maxlength' => 32]) ?>

    <?=
    $form->field($model, 'dateFrom')->widget(DatePicker::className(), [
        'options' => ['class' => 'form-control'],
        'clientOptions' => [
            'dateFormat' => 'dd-mm-yy',
        ],])
    ?>

    <?=
    $form->field($model, 'dateTo')->widget(DatePicker::className(), [
        'options' => ['class' => 'form-control'],
        'clientOptions' => [
            'dateFormat' => 'dd-mm-yy',
        ],])
    ?>

    <?= $form->field($model, 'nmStatus')->textInput(['readonly'=>true]) ?>
    
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
