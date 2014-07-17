<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var biz\master\models\ProductGroup $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="product-group-form">
    <?php $form = ActiveForm::begin(); ?>
    <div class="box box-primary">
        <div class="box-body">
            <?= $form->field($model, 'cd_group')->textInput(['maxlength' => 4]) ?>
            <?= $form->field($model, 'nm_group')->textInput(['maxlength' => 32]) ?>
        </div>
        <div class="box-footer">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
