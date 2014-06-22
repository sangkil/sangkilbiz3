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
    <div class="box-header" style="padding-bottom: 0px;">
        <i class="fa fa-filter"></i>
        <h3 class="box-title">Filter Notices</h3>
        <div class="box-tools pull-right"> 
            <?= Html::a('', '#', ['class' => 'btn btn-info btn-sm fa fa-search', 'title' => 'Min/Maximize', 'id' => 'kecilin', 'data-widget' => 'collapse']) ?>
            <?= Html::a('', '#', ['class' => 'btn btn-danger btn-sm fa fa-times', 'title' => 'Min/Maximize', 'id' => 'tutup', 'data-widget' => 'remove']) ?>
        </div>
    </div>
    <div class="box-body">
        <?= $form->field($model, 'idTransfer[transfer_num]') ?>

        <?php $itemStatus = [ $model::STATUS_CREATE => 'Draft', $model::STATUS_UPDATE => 'Updated', $model::STATUS_APPROVE => 'Approved']; ?>
        <?= $form->field($model, 'status')->dropDownList($itemStatus, ['prompt' => '--All Status--']) ?>

          <?php
        $field = $form->field($model, "notice_date", ['template' => "{label}<br><div class='col-lg-4' style='padding-left:0px;'>{date1}</div><div class='col-lg-4' style='padding-left:0px;'>{date2}</div><br>"]);

        $field->label('Notice Date (From/To)');
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
        
        <?php // echo $form->field($model, 'create_by') ?>

        <?php // echo $form->field($model, 'create_date') ?>

        <?php // echo $form->field($model, 'update_date')  ?>

    </div>
    <div class="form-group box-footer">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
