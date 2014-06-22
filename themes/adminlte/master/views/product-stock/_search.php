<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var biz\models\ProductStockSearch $model
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
        <?php $itemWhse = \biz\tools\Helper::getWarehouseList() ?>
        <?= $form->field($model, 'id_warehouse')->dropDownList($itemWhse, ['prompt' => '--All Warehouse--']) ?>

        <?= ''//$form->field($model, 'idProduct[nm_product]') ?>

        <?php
        $field = $form->field($model, 'nm_product', ['template' => "{label}\n{input}"]);
        $field->label('Nama Product');
        echo $field;
        ?>

        <?= ''//$form->field($model, 'id_product') ?>

        <?= ''//$form->field($model, 'qty_stock') ?>

        <?= ''//$form->field($model, 'id_uom') ?>

        <?= '' //$form->field($model, 'create_date') ?>

        <?php // echo $form->field($model, 'create_by') ?>

        <?php // echo $form->field($model, 'update_date') ?>

        <?php // echo $form->field($model, 'update_by')  ?>
    </div>
    <div class="form-group box-footer">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
