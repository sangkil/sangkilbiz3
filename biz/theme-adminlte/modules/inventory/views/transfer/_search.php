<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var biz\purchase\models\PurchaseSearch $model
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
        <h3 class="box-title">Filter Transfer</h3>
        <div class="box-tools pull-right"> 
            <?= Html::a('', ['create'], ['class' => 'btn btn-success btn-sm fa fa-plus', 'title' => 'New Purchase']) ?>            
            <?= Html::a('', '#', ['class' => 'btn btn-info btn-sm fa fa-search', 'title' => 'Min/Maximize', 'id' => 'kecilin', 'data-widget' => 'collapse']) ?>
            <?= Html::a('', '#', ['class' => 'btn btn-danger btn-sm fa fa-times', 'title' => 'Min/Maximize', 'id' => 'tutup', 'data-widget' => 'remove']) ?>
        </div>
    </div>
    <div class="box-body">
        <?= $form->field($model, 'transfer_num') ?>

        <?php $itemWhse = biz\master\components\Helper::getWarehouseList() ?>
        <?= $form->field($model, 'id_warehouse_dest')->dropDownList($itemWhse, ['prompt' => '--All Destination--']) ?>


        <?php $itemStatus = [ $model::STATUS_DRAFT => 'Draft', $model::STATUS_ISSUE => 'Issued']; ?>
        <?= $form->field($model, 'status')->dropDownList($itemStatus, ['prompt' => '--All Status--']) ?>

                  <?php
        $field = $form->field($model, "transfer_date", ['template' => "{label}<br><div class='col-lg-4' style='padding-left:0px;'>{date1}</div><div class='col-lg-4' style='padding-left:0px;'>{date2}</div><br>"]);

        $field->label('Transfer Date (From/To)');
        $field->parts['{date1}'] = \yii\jui\DatePicker::widget([
                    'model' => $model,
                    'attribute' => 'dateFrom',
                    'options' => ['class' => 'form-control'],
                    'clientOptions' => [
                        'dateFormat' => 'dd-mm-yy'
                    ],
        ]);
        $field->parts['{date2}'] = \yii\jui\DatePicker::widget([
                    'model' => $model,
                    'attribute' => 'dateTo',
                    'options' => ['class' => 'form-control'],
                    'clientOptions' => [
                        'dateFormat' => 'dd-mm-yy'
                    ],
        ]);
        echo $field;
        ?>

        <?php // echo $form->field($model, 'update_at') ?>

        <?php // echo $form->field($model, 'update_by') ?>

        <?php // echo $form->field($model, 'create_by') ?>

        <?php // echo $form->field($model, 'create_at')  ?>


    </div>
    <div class="form-group box-footer">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
