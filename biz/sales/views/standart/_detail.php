<?php

use yii\web\JsExpression;
use yii\jui\AutoComplete;
use biz\sales\models\SalesDtl;
use mdm\widgets\TabularInput;
use biz\app\components\Helper as AppHelper;
use biz\master\components\Helper as MasterHelper;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model biz\sales\models\Sales */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="col-lg-9" style="padding-left: 0px;">
    <div class="panel panel-info">
        <div class="panel-heading">
            Product :
            <?php
            echo AutoComplete::widget([
                'name' => 'product',
                'id' => 'product',
                'clientOptions' => [
                    'source' => new JsExpression('yii.global.sourceProduct'),
                    'select' => new JsExpression('yii.standart.onProductSelect'),
                    'delay' => 100,
                ]
            ]);
            ?>
        </div>
        <div class="panel-body" style="text-align: right;">
            <h2>Rp<span id="total-price"></h2></span>
            <?= Html::activeHiddenInput($model, 'sales_value', ['id'=>'total-price-inp'])?>
        </div>
        <table class="table table-striped">
            <?=
            TabularInput::widget([
                'id' => 'detail-grid',
                'allModels' => $model->salesDtls,
                'modelClass' => SalesDtl::className(),
                'options' => ['tag' => 'tbody'],
                'itemOptions' => ['tag' => 'tr'],
                'itemView' => '_item_detail',
                'clientOptions' => [
                    'initRow' => new JsExpression('yii.standart.initRow'),
                ]
            ]);
            ?>
        </table>
    </div>
</div>

<?php
$js = $this->render('_script',['price'=>$price],$this->context);
$this->registerJs($js, \yii\web\View::POS_END);

AppHelper::bizConfig($this, [
    'masters' => ['products', 'barcodes', 'prices', 'customers'],
    'price_ct' => $price,
]);
$js_ready = <<<JS
yii.standart.onReady();
JS;
$this->registerJs($js_ready);
