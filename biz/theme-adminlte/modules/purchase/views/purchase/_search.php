<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use biz\purchase\models\Purchase;
use yii\jui\AutoComplete;
use yii\web\JsExpression;
use biz\purchase\assets\PurchaseAsset;

/**
 * @var yii\web\View $this
 * @var biz\models\PurchaseSearch $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="box box-solid box-info">
    <?php
    $form = ActiveForm::begin([
                'action' => ['index'],
                'method' => 'get',
    ]);
    ?>
    <div class="box-header" style="padding-bottom: 0px;">
        <i class="fa fa-filter"></i>
        <h3 class="box-title">Filter Purchase</h3>
        <div class="box-tools pull-right">
            <?= Html::a('', ['create'], ['class' => 'btn btn-success btn-sm fa fa-plus', 'title' => 'New Purchase']) ?>
            <?= Html::a('', '#', ['class' => 'btn btn-info btn-sm fa fa-search', 'title' => 'Min/Maximize','id'=>'kecilin','data-widget'=>'collapse']) ?>
            <?= Html::a('', '#', ['class' => 'btn btn-danger btn-sm fa fa-times', 'title' => 'Min/Maximize','id'=>'tutup','data-widget'=>'remove']) ?>
        </div>
    </div>
    <div class="box-body">
        <?= $form->field($model, 'purchase_num') ?>
        <?= ''//$form->field($model, 'id_supplier') ?>
        <?php
        $el_id = Html::getInputId($model, 'id_supplier');
        $field = $form->field($model, "id_supplier", ['template' => "{label}\n{input}{text}\n{error}"]);
        $field->labelOptions['for'] = $el_id;
        $field->hiddenInput(['id' => 'id_supplier']);
        $field->parts['{text}'] = AutoComplete::widget([
                    'model' => $model,
                    'attribute' => 'idSupplier[nm_supplier]',
                    'options' => ['class' => 'form-control', 'id' => $el_id],
                    'clientOptions' => [
                        'source' => new JsExpression("yii.purchase.sourceSupplier"),
                    //'select' => new JsExpression("yii.purchase.onSupplierSelect"),
                    //'open' => new JsExpression("yii.purchase.onSupplierOpen"),
                    ]
        ]);
        echo $field;
        ?>
        <?php
        echo $form->field($model, 'purchaseDate')
                ->widget('yii\jui\DatePicker', [
                    'options' => ['class' => 'form-control', 'style' => 'width:50%'],
                    'clientOptions' => [
                        'dateFormat' => 'dd-mm-yy'
                    ],
        ]);
        ?>
        <?= $form->field($model, 'status')->dropDownList([Purchase::STATUS_DRAFT => 'Draft', Purchase::STATUS_RECEIVE => 'Receive'], ['prompt' => '--status--']) ?>
    </div>

    <div class="box-footer">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary', 'click' => 'js:$(\'#kecilin\').click();']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php
PurchaseAsset::register($this);
//BizDataAsset::register($this, [
//    'master' => $masters
//]);
