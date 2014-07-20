<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use biz\accounting\models\EntriSheetDtl;
use mdm\relation\EditableList;
use biz\accounting\components\Helper as AccHelper;

/* @var $model biz\accounting\models\EntriSheet */
/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $details biz\accounting\models\EntriSheetDtl[] */
?>

<?php $form = ActiveForm::begin(); ?>
<?php
$models = $model->entriSheetDtls;
array_unshift($models, $model);
echo $form->errorSummary($models);
?>
<div class="box box-primary">
    <div class="box-body no-padding">
        <div class="col-lg-5">
            <?= $form->field($model, 'cd_esheet')->textInput(['maxlength' => 4, 'style' => 'width:128px;']) ?>
            <?= $form->field($model, 'nm_esheet')->textInput(['maxlength' => 32, 'style' => 'width:320px;']) ?>
        </div>
        <div class="col-lg-7">
        </div>
    </div>
    <table class ="table table-striped" id="tbl-entryheader">
        <thead>
            <tr>
                <th>No</th>
                <th>NM Detail Entry</th>
                <th>Account</th>
                <th>
                    <a href="#" data-action="append"><span class="glyphicon glyphicon-plus"></span></a>
                </th>
            </tr>
        </thead>
        <?=
        EditableList::widget([
            'id' => 'tbl-entrydetail',
            'allModels' => $model->entriSheetDtls,
            'modelClass' => EntriSheetDtl::className(),
            'itemView' => '_detail',
            'options' => ['tag' => 'tbody'],
            'itemOptions' => ['tag' => 'tr'],
            'clientOptions' => [
                'afterAddRow' => new yii\web\JsExpression('biz.config.entryAfterAddRow'),
            ]
        ])
        ?>
    </table>
    <div class="box-footer">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
</div>
<?php ActiveForm::end(); ?>
<?php
yii\jui\AutoCompleteAsset::register($this);
yii\jui\ThemeAsset::register($this);
biz\app\assets\BizAsset::register($this);
$jsFunc = <<<JS
function (\$row) {
    \$row.find('.nm_account').autocomplete({
        source: biz.master.coas,
        select: function (event, ui) {
            var \$row = $(event.target).closest('tr');
            \$row.find('.id_account').val(ui.item.id);
            \$row.find('.cd_account').text(ui.item.cd_coa);
            \$row.find('.nm_account').val(ui.item.value);

            return false;
        }
    });
}
JS;
biz\app\assets\BizDataAsset::register($this, [
    'master' => AccHelper::getMasters('coa'),
    'config' => [
        'entryAfterAddRow' => new \yii\web\JsExpression($jsFunc)
    ]
]);
$js = <<<JS
\$('#tbl-entryheader a[data-action="append"]').click(function () {
    $('#tbl-entrydetail').mdmEditableList('addRow');

    return false;
});
JS;

$this->registerJs($js);
