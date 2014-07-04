<?php

use yii\web\JsExpression;
use yii\jui\AutoComplete;
use biz\sales\models\SalesDtl;
use mdm\relation\EditableList;
use biz\sales\assets\StandartAsset;
use biz\app\assets\BizDataAsset;
use biz\master\components\Helper as MasterHelper;
use biz\master\models\PriceCategory;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model biz\sales\models\Sales */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="col-lg-9" style="padding-left: 0px;">
    <div class="panel panel-info">
        Price :
        <?=
        Html::dropDownList('price_ct', null, ArrayHelper::map(PriceCategory::findAll([]), 'id_price_category', 'nm_price_category'), ['id' => 'price_ct'])
        ?>

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
            <input type="hidden" data-field="total_price"><h2>Rp<span id="total-price"></h2></span>
        </div>
        <table class="table table-striped">
            <?=
            EditableList::widget([
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
StandartAsset::register($this);
BizDataAsset::register($this, [
    'master' => MasterHelper::getMasters('product, barcode, price, price_category, customer'),
]);
$js_ready = <<<JS
yii.standart.onReady();
JS;
$this->registerJs($js_ready);
