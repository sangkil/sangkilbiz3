<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use biz\tools\Helper;

/**
 * @var yii\web\View $this
 * @var biz\models\User2Branch $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="user2-branch-form">
    <?php $form = ActiveForm::begin(); ?>
    <div class="box box-info no-padding">
        <div class="box-body">
            <?= ''//$form->field($model, 'id_branch')->textInput() ?>
            <?= $form->field($model, 'id_branch')->dropDownList(Helper::getBranchList()) ?>                 

            <?= $form->field($model, 'id_user')->textInput() ?>            

            <?= $form->field($model, 'is_active')->checkbox([],false) ?>

        </div>
        <div class="box-footer">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>

</div>
