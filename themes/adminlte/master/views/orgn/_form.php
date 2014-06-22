<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var biz\models\Orgn $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="orgn-form" style="padding-left: 0px;">
    <?php $form = ActiveForm::begin(); ?>
    <div class="box box-warning">
        <div class="box-body">
            <?= $form->field($model, 'cd_orgn')->textInput(['maxlength' => 4, 'style' => 'width:120px;']) ?>

            <?= $form->field($model, 'nm_orgn')->textInput(['maxlength' => 64]) ?>
        </div>

        <div class="box-footer">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
