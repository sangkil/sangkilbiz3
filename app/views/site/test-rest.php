<?php

use yii\base\DynamicModel;
use yii\widgets\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */

$model = new DynamicModel([
    'url', 'params'
    ]);
?>
<div class="row">

    <?php $form = ActiveForm::begin() ?>
    <?= $form->field($model, 'url')->textInput(['id' => 'url']) ?>
    <?= $form->field($model, 'params')->textarea(['rows' => 8, 'id' => 'params']) ?>
    <div class="form-group field-dynamicmodel-params">
        <label class="control-label">Result</label>
        <span id="result" class="form-control"></span>
    </div>
    <div class="form-group" id="btns">
        <?= Html::a('GET', '#', ['class' => 'btn btn-success']) ?>
        <?= Html::a('PUT', '#', ['class' => 'btn btn-success']) ?>
        <?= Html::a('POST', '#', ['class' => 'btn btn-success']) ?>
        <?= Html::a('DELETE', '#', ['class' => 'btn btn-success']) ?>
    </div>
</div>
<?php ActiveForm::end() ?>
<?php 
$js = <<<JS
    $('#btns > a').click(function(){
        var method = $(this).text();
        var url = $('#url').val();
        var params = JSON.parse($('#params').val());
        $.ajax(url,{
            type:method,
            data:params,
            success:function(r){
                console.log(r);
            }
        });
        return false;
   });
JS;
$this->registerJs($js);