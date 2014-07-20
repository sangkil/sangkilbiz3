<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;
use biz\master\components\Helper;

/* @var $this yii\web\View */
?>

<div class="gl-header-form">

    <?php
    $form = ActiveForm::begin();
    echo $form->errorSummary($model);
    ?>
    <div class="box box-danger no-padding">
        <div class="box-body">
            <div class="col-lg-5">
                <div class="form-group field-glheader-gldate required">
                    <?php
                    echo Html::label('Select Category', 'sheet');
                    echo Html::dropDownList('', $es, $sheets, ['id' => 'sheets', 'prompt' => '-', 'class' => 'form-control']);
                    ?>
                </div>
                <?= $form->field($model, 'gl_num')->textInput(['style' => 'width:60%']) ?>
                <?=
                $form->field($model, 'glDate')->widget(DatePicker::className(), [
                    'options' => ['class' => 'form-control', 'style' => 'width:60%'],
                    'clientOptions' => [
                        'dateFormat' => 'dd-mm-yy'
                    ],
                ]);
                ?>
            </div>
            <div class="col-lg-7">
                <?= $form->field($model, 'id_periode')->textInput(['style' => 'width:30%']) ?>
                <?= $form->field($model, 'id_branch')->dropDownList(Helper::getBranchList()) ?>
                <?= $form->field($model, 'description')->textarea() ?>
                <?= ''//$form->field($model, 'gl_memo')->textInput(['maxlength' => 128]) ?>
            </div>
        </div>
        <table class="table table-striped table-condensed">
            <thead>
                <tr>
                    <th style="width: 40%">Akun</th>
                    <th>Debit</th>
                    <th>Kredit</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (!empty($details)) {
                    echo $this->render('_detail', [
                        'form' => $form,
                        'details' => $details
                    ]);
                }
                ?>
            </tbody>
        </table>
        <div class="box-footer">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php
$url = \yii\helpers\Url::toRoute(['create']);
$js = <<<JS
    \$('#sheets').change(function () {
        window.location.href = '{$url}&es='+\$(this).val();
   });
JS;
$this->registerJs($js);
