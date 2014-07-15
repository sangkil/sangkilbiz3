<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use biz\master\components\Helper;

/**
 * @var yii\web\View $this
 * @var biz\models\BranchSearch $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="branch-search box box-warning">
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
        <?php $itemWhse = Helper::getOrgnList() ?>
        <?= $form->field($model, 'id_orgn')->dropDownList($itemWhse, ['prompt' => '--All Orgn--']) ?>

        <?= $form->field($model, 'cd_branch') ?>

        <?= $form->field($model, 'nm_branch') ?>
    </div>

    <div class="box-footer">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary', 'click' => 'js:$(\'#kecilin\').click();']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
