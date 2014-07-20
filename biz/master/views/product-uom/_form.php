<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\AutoComplete;
use yii\web\JsExpression;
use yii\helpers\ArrayHelper;
use biz\master\models\Uom;
use biz\app\assets\BizAsset;
use biz\app\assets\BizDataAsset;
use biz\master\components\Helper as MasterHelper;

/* @var $this yii\web\View */
/* @var $model biz\master\models\ProductUom */
/* @var $form yii\widgets\ActiveForm */
?>

<div class=" product-uom-form col-lg-6" style="padding-left: 0px;">

    <?php $form = ActiveForm::begin(); ?>
    <div class="panel panel-primary">
        <div class="panel-heading">Product Uoms</div>
        <div class="panel-body">
            <?=
            $form->field($model, 'nmProduct')->widget('yii\jui\AutoComplete', [
                'id' => 'product',
                'options' => ['class' => 'form-control'],
                'clientOptions' => [
                    'source' => new JsExpression('yii.global.sourceProduct'),
                    'delay' => 100,
                ]
            ])
            ?>

            <?= $form->field($model, 'id_uom')->dropDownList(ArrayHelper::map(Uom::find()->all(), 'id_uom', 'nm_uom'), ['style' => 'width:200px;']); ?>

            <?= $form->field($model, 'isi')->textInput() ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php
BizAsset::register($this);
BizDataAsset::register($this, [
    'master' => MasterHelper::getMasters('product, barcode'),
]);
$js_ready = <<<JS
JS;
$this->registerJs($js_ready);

?>
