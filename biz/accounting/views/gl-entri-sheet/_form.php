<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;
use mdm\relation\EditableList;
use biz\accounting\models\GlDetail;

/* @var $this yii\web\View */
/* @var $model biz\accounting\models\GlHeader */
?>

<div class="gl-header-form">

    <?php
    $sheets = biz\accounting\models\EntriSheet::find()->all();
    $sheets = \yii\helpers\ArrayHelper::map($sheets, 'id_esheet', 'nm_esheet');
    echo Html::dropDownList('', $es, $sheets, ['id' => 'sheets', 'prompt' => '-']); ?>
    <?php $form = ActiveForm::begin(); ?>
    <?php
    $models = $model->glDetails;
    array_unshift($models, $model);
    echo $form->errorSummary($models);
    ?>

    <?=
    $form->field($model, 'glDate')->widget(DatePicker::className(), [
        'options' => ['class' => 'form-control', 'style' => 'width:50%'],
        'clientOptions' => [
            'dateFormat' => 'dd-mm-yy'
        ],
    ]);
    ?>
    <?= $form->field($model, 'id_branch')->textInput() ?>

    <?= $form->field($model, 'id_periode')->textInput() ?>

    <?= $form->field($model, 'description')->textInput() ?>

    <table style="width: 98%">
        <thead>
            <tr>
                <th style="width: 40%">Akun</th>
                <th>Debit</th>
                <th>Kredit</th>
            </tr>
        </thead>
        <?=
        EditableList::widget([
            'id'=>'gl-detail',
            'allModels' => $model->glDetails,
            'modelClass' => GlDetail::className(),
            'itemView' => '_detail',
            'options' => ['tag' => 'tbody'],
            'itemOptions' => ['tag' => 'tr'],
            'viewParams'=>['form'=>$form]
        ])
        ?>
    </table>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php
$url = \yii\helpers\Url::toRoute(['create']);
$js = <<<JS
yii.numeric.format(\$('#gl-detail'),'input.amount');

\$('#sheets').change(function () {
    window.location.href = '{$url}&es='+\$(this).val();
});
JS;
$this->registerJs($js);
biz\app\assets\BizAsset::register($this);
