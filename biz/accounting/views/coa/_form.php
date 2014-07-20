<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use biz\accounting\components\Helper;

/* @var $this yii\web\View */
/* @var $model biz\accounting\models\Coa */
/* @var $form  yii\widgets\ActiveForm */
?>

<div class="coa-form col-lg-6">

    <?php $form = ActiveForm::begin(); ?>
    <div class="panel panel-primary">
        <div class="panel-heading">Chart of Account</div>
        <div class="panel-body">
            <?=
            $form->field($model, 'id_parent')->dropDownList(Helper::getGroupedCoaList(true), [
                'encodeSpaces' => true,
            ]);
            ?>

            <?= $form->field($model, 'cd_account')->textInput(['maxlength' => 16, 'style' => 'width:180px;']) ?>

            <?= $form->field($model, 'nm_account')->textInput(['maxlength' => 64]) ?>

        </div>

    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
