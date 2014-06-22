<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use biz\models\Orgn;

/**
 * @var yii\web\View $this
 * @var biz\models\Branch $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="branch-form" style="padding-left: 0px;">
    <?php $form = ActiveForm::begin(); ?>
    <div class="box box-danger">
        <div class="box-body">
            <?= $form->field($model, 'id_orgn')->dropDownList(ArrayHelper::map(Orgn::find()->all(), 'id_orgn', 'nm_orgn'), ['style' => 'width:200px;']); ?>

            <?= $form->field($model, 'cd_branch')->textInput(['maxlength' => 4, 'style' => 'width:120px;']) ?>

            <?= $form->field($model, 'nm_branch')->textInput(['maxlength' => 32]) ?>
        </div>
        <div class="box-footer">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>

</div>
