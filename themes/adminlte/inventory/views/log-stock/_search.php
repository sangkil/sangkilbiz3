<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var biz\models\searchs\TransferNotice $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="transfer-notice-search box box-warning">

    <?php
    $form = ActiveForm::begin([
                'action' => ['index'],
                'method' => 'get',
    ]);
    ?>
    
    <div class="box-body">
        <?php $itemBranch = biz\tools\Helper::getWarehouseList(); ?>
        <?= $form->field($model, 'id_warehouse')->dropDownList($itemBranch, ['prompt' => '--All Warehouse--']) ?>
    </div>

    <div class="box-footer">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
