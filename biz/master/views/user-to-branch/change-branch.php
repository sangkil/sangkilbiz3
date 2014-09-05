<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model yii\base\DynamicModel */
/* @var $branchs biz\master\models\Branch[] */
?>
<?php $form = yii\widgets\ActiveForm::begin() ?>
<?= $form->field($model, 'selected')->dropDownList(ArrayHelper::map($branchs, 'id_branch', 'nm_branch')) ?>
<div class="form-group">
    <?= Html::submitButton('Change', ['class' => 'btn btn-primary']) ?>
</div>

<?php
yii\widgets\ActiveForm::end()?>