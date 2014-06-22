<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var biz\purchase\models\PurchaseHdrSearch $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="purchase-hdr-search box box-warning">
    <?php
    $form = ActiveForm::begin([
                'action' => ['index'],
                'method' => 'get',
    ]);
    ?>
    <div class="box-header" style="padding-bottom: 0px;">
        <i class="fa fa-filter"></i>
        <h3 class="box-title">Filter Receive</h3>
        <div class="box-tools pull-right">
            <?= Html::a('', '#', ['class' => 'btn btn-info btn-sm fa fa-search', 'title' => 'Min/Maximize', 'id' => 'kecilin', 'data-widget' => 'collapse']) ?>
            <?= Html::a('', '#', ['class' => 'btn btn-danger btn-sm fa fa-times', 'title' => 'Min/Maximize', 'id' => 'tutup', 'data-widget' => 'remove']) ?>
        </div>
    </div>
    <div class="box-body">
        <?= $form->field($model, 'transfer_num') ?>

        <?= $form->field($model, 'id_warehouse_dest') ?>
        
        <?php $itemStatus = [ $model::STATUS_ISSUE => 'Issued', $model::STATUS_DRAFT_RECEIVE => 'Draft Receive', $model::STATUS_RECEIVE => 'Receive']; ?>
        <?= $form->field($model, 'status')->dropDownList($itemStatus, ['prompt' => '--All Status--']) ?>

        <?= $form->field($model, 'transfer_date') ?>

        <?php // echo $form->field($model, 'id_status') ?>

        <?php // echo $form->field($model, 'update_date') ?>

        <?php // echo $form->field($model, 'update_by') ?>

        <?php // echo $form->field($model, 'create_by') ?>

        <?php // echo $form->field($model, 'create_date')  ?>


    </div>
    <div class="form-group box-footer">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
