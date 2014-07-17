<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var biz\master\models\Price $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="price-form">
    <?php $form = ActiveForm::begin(); ?>

    <div class="box box-primary">
        <div class="box-body">
            <?= $form->field($model, 'id_product')->textInput() ?>

            <?= $form->field($model, 'id_price_category')->textInput() ?>

            <?= $form->field($model, 'id_uom')->textInput() ?>

            <?= $form->field($model, 'price')->textInput() ?>
        </div>

        <div class="box-footer">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
