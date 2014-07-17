<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use biz\master\components\Helper;

/* @var $this yii\web\View */
/* @var $model biz\inventory\models\Transfer */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="purchase-hdr-form">
    <?php
    $form = ActiveForm::begin([
                'id' => 'transfer-form',
    ]);
    ?>
    <?php
    $models = $model->transferDtls;
    array_unshift($models, $model);
    echo $form->errorSummary($models)
    ?>
    <div class="col-lg-4">
        <div class="box box-primary">
            <div class="box-body">
                <?= $form->field($model, 'transfer_num')->textInput(['maxlength' => 16, 'readonly' => true]); ?>
                <?= $form->field($model, 'id_warehouse_source')->dropDownList(Helper::getWarehouseList()); ?>
                <?= $form->field($model, 'id_warehouse_dest')->dropDownList(Helper::getWarehouseList()); ?>
                <?php
                echo $form->field($model, 'transferDate')
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
                echo Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']);
                ?>
            </div>
        </div>
    </div>
    <div class="col-lg-8">
        <?= $this->render('_detail', ['model' => $model]) ?> 
    </div>    
    <?php ActiveForm::end(); ?>
</div>