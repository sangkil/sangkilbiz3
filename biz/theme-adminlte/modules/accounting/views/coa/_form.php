<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use biz\accounting\components\Helper;

/**
 * @var yii\web\View $this
 * @var biz\models\\Coa $model
 * @var yii\widgets\ActiveForm $form
 */
?>
<?php $form = ActiveForm::begin(); ?>
<div class="box box-primary">
    <div class="box-header">&nbsp;</div>
    <div class="box-body">
        <?php // $form->field($model, 'coa_type')->dropDownList(Coa::getCoaType(), ['style' => 'width:180px;']) ?>

        <?= $form->field($model, 'id_parent')->dropDownList(Helper::getGroupedCoaList(true)); ?>

        <?= $form->field($model, 'cd_account')->textInput(['maxlength' => 16, 'style' => 'width:160px;']) ?>

        <?= $form->field($model, 'nm_account')->textInput(['maxlength' => 64, 'style' => 'width:240px;']) ?>

        <?php
//            $el_id = Html::getInputId($model, 'id_parent');
//            $field = $form->field($model, "id_parent", ['template' => "{label}\n{input}{text}\n{hint}\n{error}"]);
//            $field->labelOptions['for'] = $el_id;
//            $field->hiddenInput(['id' => 'id_parent']);
//            $field->parts['{text}'] = AutoComplete::widget([
//                    'model' => $model,
//                    'attribute' => 'idCoaParent[nm_account]',
//                    'options' => ['class' => 'form-control', 'id' => $el_id],
//                    'clientOptions' => [
//                        'source' => yii\helpers\Url::toRoute(['coa-list']),
//                        'select' => new JsExpression('function(event,ui){$(\'#id_parent\').val(ui.item.id)}'),
//                        'open' => new JsExpression('function(event,ui){$(\'#id_parent\').val(\'\')}'),
//                    ]
//            ]);
//            $field;
        ?>

        <?php // $form->field($model, 'normal_balance')->radioList(Coa::getBalanceType()) ?>

    </div>
    <div class="box-footer">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
</div>



<?php ActiveForm::end(); ?>
