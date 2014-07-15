<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\web\JsExpression;
use biz\master\components\Helper;

/**
 * @var yii\web\View $this
 * @var biz\purchase\models\Purchase $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="purchase-hdr-form">
    <?php
    $form = ActiveForm::begin([
            'id' => 'purchase-form',
    ]);
    ?>
    <?php
    $models = $details;
    $models[] = $model;
    echo $form->errorSummary($models)
    ?>
    <div class="col-lg-3">
        <div class="box box-primary">
            <div class="box-body">
                <?= $form->field($model, 'purchase_num')->textInput(['maxlength' => 16, 'readonly' => true]); ?>
                <?=
                    $form->field($model, 'nmSupplier')
                    ->widget('yii\jui\AutoComplete', [
                        'options' => ['class' => 'form-control'],
                        'clientOptions' => [
                            'source' => new JsExpression("biz.master.suppliers"),
                        ]
                ]);
                ?>
                <?= $form->field($model, 'id_warehouse')->dropDownList(Helper::getWarehouseList()); ?>
                <?=
                    $form->field($model, 'purchaseDate')
                    ->widget('yii\jui\DatePicker', [
                        'options' => ['class' => 'form-control', 'style' => 'width:50%'],
                        'clientOptions' => [
                            'dateFormat' => 'dd-mm-yy'
                        ],
                ]);
                ?>
            </div>
            <div class="box-footer" style="text-align: right;">
                <?php
                echo Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']);
                ?>
            </div>
        </div>
    </div>    
    <?=
    $this->render('_detail', [
        'model' => $model,
        'details' => $details
    ])
    ?> 
    <?php ActiveForm::end(); ?>
</div>