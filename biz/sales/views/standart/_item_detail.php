<?php

use yii\helpers\Html;
use biz\master\components\Helper;

/* @var $this yii\web\View */
?>
<td style="width: 50px">
    <a data-action="delete" title="Delete" href="#"><span class="glyphicon glyphicon-trash"></span></a>
    <?= Html::activeHiddenInput($model, "[$key]id_product", ['data-field' => 'id_product', 'id' => false]) ?>
    <?= Html::activeHiddenInput($model, "[$key]id_sales_dtl", ['data-field' => 'id_sales_dtl', 'id' => false]) ?>
</td>
<td class="items" style="width: 45%">
    <ul class="nav nav-list">
        <li><span class="cd_product"><?= Html::getAttributeValue($model, 'idProduct[cd_product]') ?></span> 
            - <span class="nm_product"><?= Html::getAttributeValue($model, 'idProduct[nm_product]') ?></span></li>
        <li>
            Jumlah <?=
            Html::activeTextInput($model, "[$key]sales_qty", [
                'data-field' => 'sales_qty',
                'size' => 5, 'id' => false,
                'required' => true])
            ?>
            <?= Html::activeDropDownList($model, "[$key]id_uom", Helper::getProductUomList($model->id_product), ['data-field' => 'id_uom', 'id' => false]) ?>
        </li>
        <li>
            <?= Html::activeHiddenInput($model, "[$key]sales_price", ['data-field' => 'sales_price', 'id' => false]) ?>
            Price Rp <span class="sales_price"><?= Html::getAttributeValue($model, 'sales_price') ?></span> 
        </li>
    </ul>
</td>
<td class="selling" style="width: 40%">
    <ul class="nav nav-list">
        <li>Discon</li>
        <li>
            <?php
            $sales_price = $model->sales_price;
            $discon = $model->discount;
            $discon_percen = $sales_price > 0 ? 100 * $discon / $sales_price : 0;
            $discon_percen = round($discon_percen, 2);
            ?>
            Percen <?=
            Html::textInput('', $discon_percen, [
                'data-field' => 'discount_percen',
                'size' => 8, 'id' => false,
                'required' => false])
            ?> %
        </li>
        <li>
            Discon Rp <?=
            Html::activeTextInput($model, "[$key]discount", [
                'data-field' => 'discount',
                'size' => 16, 'id' => false,
                'required' => false])
            ?>
        </li>
    </ul>
</td>
<td class="total-price">
    <ul class="nav nav-list">
        <li>&nbsp;</li>
        <li>
            <input type="hidden" data-field="total_price"><span class="total-price"></span>
        </li>
    </ul>
</td>