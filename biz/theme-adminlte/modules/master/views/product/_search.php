<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var biz\models\searchs\Product $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="product-search box box-warning">

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
            <?= Html::a('', '#', ['class' => 'btn btn-info btn-sm fa fa-search', 'title' => 'Min/Maximize', 'id' => 'kecilin', 'data-widget' => 'collapse']) ?>
            <?= Html::a('', '#', ['class' => 'btn btn-danger btn-sm fa fa-times', 'title' => 'Min/Maximize', 'id' => 'tutup', 'data-widget' => 'remove']) ?>
        </div>
    </div>
    <div class="box-body">
        <?= $form->field($model, 'cd_product') ?>

        <?= $form->field($model, 'nm_product') ?>

        <?php $itemWhse = \biz\tools\Helper::getProductCategoryList() ?>
        <?= $form->field($model, 'id_category')->dropDownList($itemWhse, ['prompt' => '--All Category--']) ?>

        <?php $itemGroup = \biz\tools\Helper::getProductGroupList() ?>
        <?= $form->field($model, 'id_group')->dropDownList($itemGroup, ['prompt' => '--All Groups--']) ?>

        <?php // echo $form->field($model, 'create_date') ?>

        <?php // echo $form->field($model, 'create_by') ?>

        <?php // echo $form->field($model, 'update_date') ?>

        <?php // echo $form->field($model, 'update_by')  ?>

    </div>

    <div class="box-footer">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary', 'click' => 'js:$(\'#kecilin\').click();']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
