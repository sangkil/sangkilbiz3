<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var biz\master\models\ProductStockSearch $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="product-stock-search box box-warning">
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
            <?= ''//Html::a('', ['create'], ['class' => 'btn btn-success btn-sm fa fa-plus', 'title' => 'New Purchase']) ?>
            <?= Html::a('', '#', ['class' => 'btn btn-info btn-sm fa fa-search', 'title' => 'Min/Maximize', 'id' => 'kecilin', 'data-widget' => 'collapse']) ?>
            <?= Html::a('', '#', ['class' => 'btn btn-danger btn-sm fa fa-times', 'title' => 'Min/Maximize', 'id' => 'tutup', 'data-widget' => 'remove']) ?>
        </div>
    </div>
    <div class="box-body">
        <?= ''//$form->field($model, 'id_warehouse') ?>

        <?= ''//$form->field($model, 'opening_date') ?>

        <?= $form->field($model, 'id_product') ?>

        <?= $form->field($model, 'id_uom') ?>

        <?php // echo $form->field($model, 'qty_stock') ?>

        <?php // echo $form->field($model, 'status_closing') ?>

        <?php // echo $form->field($model, 'create_at') ?>

        <?php // echo $form->field($model, 'create_by') ?>

        <?php // echo $form->field($model, 'update_at') ?>

        <?php // echo $form->field($model, 'update_by') ?>

    </div>

    <div class="box-footer">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary', 'click' => 'js:$(\'#kecilin\').click();']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
