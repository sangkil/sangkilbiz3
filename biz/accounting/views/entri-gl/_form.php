<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use biz\accounting\models\GlDetail;
use mdm\relation\EditableList;

/* @var $model biz\accounting\models\GlHeader */
/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $details biz\accounting\models\GlDetails[] */
?>

<div class="gl-header-form">
    <?php $form = ActiveForm::begin(); ?>
    <?php
    $models = $details;
    array_unshift($models, $model);
    echo $form->errorSummary($models);
    ?>
    <div class="panel panel-primary col-lg-8 no-padding">
        <div class="panel-body">
            <div class="col-lg-5">
                <?=
                    $form->field($model, 'glDate')
                    ->widget('yii\jui\DatePicker', [
                        'options' => ['class' => 'form-control', 'style' => 'width:50%'],
                        'clientOptions' => [
                            'dateFormat' => 'dd-mm-yy'
                        ],
                ]);
                ?>
                <?= $form->field($model, 'id_branch')->textInput() ?>
            </div>
            <div class="col-lg-7">
                <?= $form->field($model, 'type_reff')->textInput() ?>
                <?= $form->field($model, 'description')->textarea() ?>
            </div>
        </div>
        <table class ="table table-striped" id="tbl-glheader">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Account</th>
                    <th>Debit</th>
                    <th>Credit</th>
                    <th><a class="fa fa-plus-square" href="#" data-action="append">
                            <span class="glyphicon glyphicon-plus"></span>
                        </a>
                    </th>
                </tr>
            </thead>
            <?=
            EditableList::widget([
                'id' => 'tbl-gldetail',
                'allModels' => $details,
                'itemView' => '_detail',
                'modelClass' => GlDetail::className(),
                'options' => ['tag' => 'tbody'],
                'itemOptions' => ['tag' => 'tr'],
                'clientOptions' => [
                    'afterAddRow' => new yii\web\JsExpression('biz.config.glAfterAddRow'),
                ]
            ])
            ?>
        </table>

        <div class="panel-footer">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>
<?php
yii\jui\AutoCompleteAsset::register($this);
yii\jui\ThemeAsset::register($this);
biz\app\assets\BizAsset::register($this);
$jsFunc = <<<JS
function(\$row) {
    \$row.find('.nm_account').autocomplete({
        source: biz.master.coas,
        select: function(event, ui) {
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
    'master' => $masters,
    'config' => [
        'glAfterAddRow' => new \yii\web\JsExpression($jsFunc)
    ]
]);
$js = <<<JS
\$('#tbl-glheader a[data-action="append"]').click(function() {
    $('#tbl-gldetail').mdmEditableList('addRow');
    return false;
});

yii.numeric.input(\$('#tbl-glheader'),'input.amount');
yii.numeric.format(\$('#tbl-glheader'),'input.amount');

JS;

$this->registerJs($js);
