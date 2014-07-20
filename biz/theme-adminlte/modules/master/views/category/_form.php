<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var biz\master\models\Category $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="box box-primary">
    <?php $form = ActiveForm::begin(); ?>
    <div class="box-body">
        <?= $form->field($model, 'cd_category')->textInput(['maxlength' => 4]) ?>

        <?= $form->field($model, 'nm_category')->textInput(['maxlength' => 32]) ?>

        <div class="box-footer">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>

    </div>

    <?php ActiveForm::end(); ?>

</div>
