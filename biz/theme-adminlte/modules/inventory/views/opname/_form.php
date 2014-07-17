<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model biz\inventory\models\StockOpname */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="stock-opname-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_warehouse')->textInput() ?>

    <?=
    $form->field($model, 'opnameDate')->widget('yii\jui\DatePicker', [
        'options' => ['class' => 'form-control', 'style' => 'width:50%'],
        'clientOptions' => [
            'dateFormat' => 'dd-mm-yy'
        ],
    ])
    ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'operator')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
