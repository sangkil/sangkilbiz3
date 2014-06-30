<?php

use yii\web\JsExpression;
use yii\jui\AutoComplete;
use biz\sales\models\SalesDtl;
use mdm\relation\EditableList;
use biz\sales\assets\StandartAsset;
use biz\app\assets\BizDataAsset;
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
            <input type="hidden" data-field="total_price"><h2>Rp<span id="total-price"></h2></span>
        </div>
        <table class="table table-striped">
            <?=
            EditableList::widget([
                'id' => 'detail-grid',
                'allModels' => $details,
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
    'master' => $masters,
]);
$js_ready = <<<JS
$("#product").data("ui-autocomplete")._renderItem = yii.global.renderItem;
yii.numeric.input(\$('#detail-grid'), 'input[data-field]');
yii.standart.onReady();
JS;
$this->registerJs($js_ready);
