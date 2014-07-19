<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use biz\master\models\searchs\Branch;

/**
 * @var yii\web\View $this
 * @var biz\models\Warehouse $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="warehouse-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="box box-warning">
        <div class="box-body">
            <?= $form->field($model, 'id_branch')->dropDownList(ArrayHelper::map(Branch::find()->all(), 'id_branch', 'nm_branch'), ['style' => 'width:200px;']) ?>

            <?= $form->field($model, 'cd_whse')->textInput(['maxlength' => 4, 'style' => 'width:120px;']) ?>

            <?= $form->field($model, 'nm_whse')->textInput(['maxlength' => 32]) ?>
        </div>
        <div class="box-footer">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
