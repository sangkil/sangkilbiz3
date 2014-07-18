<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model biz\purchase\models\Purchase */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="receive-form">
    <?php
    $form = ActiveForm::begin([
                'id' => 'receive-form',
    ]);
    ?>
    <?php
    $models = $details;
    $models[] = $model;
    echo $form->errorSummary($models)
    ?>
    <div class="col-lg-4">
        <div class="box box-primary">
            <div class="box-body">
                <?= $form->field($model, 'transfer_num')->textInput(['readonly' => true]); ?>
                <?= $form->field($model, 'idWarehouseSource[nm_whse]')->textInput(['readonly' => true]); ?>
                <?= $form->field($model, 'idWarehouseDest[nm_whse]')->textInput(['readonly' => true]); ?>
                <?= $form->field($model, 'transferDate')->textInput(['readonly' => true]); ?>
                <?php
                echo $form->field($model, 'receiveDate')
                        ->widget('yii\jui\DatePicker', [
                            'options' => ['class' => 'form-control', 'style' => 'width:50%'],
                            'clientOptions' => [
                                'dateFormat' => 'dd-mm-yy'
                            ],
                ]);
                ?>
            </div>
            <div class="box-footer">
                <?php
                echo Html::submitButton('Update', ['class' => 'btn btn-primary']);
                ?>
            </div>
        </div>
    </div>   
    <div class="col-lg-8">         
        <?= $this->render('_detail', ['model' => $model, 'details' => $details]) ?>
    </div> 
    <?php ActiveForm::end(); ?>
</div>