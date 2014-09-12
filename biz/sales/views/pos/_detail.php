<?php

use yii\web\JsExpression;
use yii\jui\AutoComplete;
use mdm\widgets\TabularInput;
?>
<div class="box box-info">
    <div class="box-header">
        <div class="form-group" style="padding: 15px;">
            <label for="product">Product :</label>
            <?php
            echo AutoComplete::widget([
                'name' => 'product',
                'id' => 'product',
                'clientOptions' => [
                    'source' => new JsExpression('yii.global.sourceProduct'),
                    'select' => new JsExpression('yii.pos.onSelectProduct'),
                    'delay' => 500
                ],
                'options' => ['class' => 'form-control'],
            ]);
            ?>
        </div>
        <div class="box-body" style="text-align: right; padding-top: 0px; padding-bottom: 0px;">
            <input type="hidden" id="h-total-price"><h2>Rp<span id="total-price"></span></h2>
        </div>
    </div>
    <table id="detail-grid" class="table table-striped no-padding" style="padding: 0px;">
        <?=
        TabularInput::widget([
            'id' => 'detail-grid',
//          'allModels' => $model->salesDtls,
//          'modelClass' => SalesDtl::className(),
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
