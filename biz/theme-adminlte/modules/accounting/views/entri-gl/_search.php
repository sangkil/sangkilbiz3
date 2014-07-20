<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var biz\models\searchs\GlHeader $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<?php
$form = ActiveForm::begin([
            'action' => ['index'],
            'method' => 'get',
        ]);
?>

<div class="gl-header-search box box-warning">
    <div class="box-header" style="padding-bottom: 0px;">
        <i class="fa fa-filter"></i>
        <h3 class="box-title">Filter GL</h3>
        <div class="box-tools pull-right">
            <?= Html::a('', '#', ['class' => 'btn btn-info btn-sm fa fa-search', 'title' => 'Min/Maximize', 'id' => 'kecilin', 'data-widget' => 'collapse']) ?>
            <?= Html::a('', '#', ['class' => 'btn btn-danger btn-sm fa fa-times', 'title' => 'Min/Maximize', 'id' => 'tutup', 'data-widget' => 'remove']) ?>
        </div>
    </div>
    <div class="box-body">
        <?= $form->field($model, 'gl_num') ?>

        <?= $form->field($model, 'description') ?>

        <?php $itemBrnch = \biz\master\components\Helper::getBranchList() ?>
        <?= $form->field($model, 'id_branch')->dropDownList($itemBrnch, ['prompt' => '--All Status--']) ?>

        <?php
        $field = $form->field($model, "gl_date", ['template' => "{label}<br><div class='col-lg-4' style='padding-left:0px;'>{date1}</div><div class='col-lg-4' style='padding-left:0px;'>{date2}</div><br>"]);

        $field->label('Date Receive (From/To)');
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

        <?= ''//$form->field($model, 'gl_date') ?>

        <?php // echo $form->field($model, 'id_periode') ?>

        <?php // echo $form->field($model, 'type_reff') ?>

        <?php // echo $form->field($model, 'id_reff') ?>

        <?php // echo $form->field($model, 'status') ?>

        <?php // echo $form->field($model, 'create_at') ?>

        <?php // echo $form->field($model, 'create_by') ?>

        <?php // echo $form->field($model, 'update_at') ?>

        <?php // echo $form->field($model, 'update_by')  ?>

    </div>

    <div class="form-group box-footer">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>
</div>

<?php ActiveForm::end(); ?>
