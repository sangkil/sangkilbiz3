<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use biz\master\models\GlobalConfig;

/**
 * @var yii\web\View $this
 * @var biz\master\models\GlobalConfig $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="global-config-form">

	<?php $form = ActiveForm::begin(); ?>

	<?php
    $groups = GlobalConfig::find()->select('group')->distinct(true)->column();
    echo $form->field($model, 'group')->widget('yii\jui\AutoComplete', [
        'options' => ['class' => 'form-control', 'maxlength' => 16],
        'clientOptions' => [
            'source' => $groups
        ]
    ])
    ?>

	<?= $form->field($model, 'name')->textInput(['maxlength' => 32]) ?>

	<?= $form->field($model, 'value')->textInput() ?>

	<?= $form->field($model, 'description')->textInput(['maxlength' => 128]) ?>

    <div class="form-group">
		<?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

	<?php ActiveForm::end(); ?>

</div>
