<?php

use yii\helpers\Html;
use biz\master\components\Helper;


/* @var $this yii\web\View */
?>
<td style="width: 50px">
    <a data-action="delete" title="Delete" href="#"><span class="glyphicon glyphicon-trash"></span></a>
    <?= Html::activeHiddenInput($model, "[$key]id_product", ['data-field' => 'id_product', 'id' => false]) ?>
    <?= Html::activeHiddenInput($model, "[$key]id_purchase_dtl", ['data-field' => 'id_purchase_dtl', 'id' => false]) ?>
</td>
<td class="items" style="width: 45%">
    <ul class="nav nav-list">
        <li><span class="cd_product"><?= Html::getAttributeValue($model, 'idProduct[cd_product]') ?></span> 
            - <span class="nm_product"><?= Html::getAttributeValue($model, 'idProduct[nm_product]') ?></span></li>
        <li>
            Jumlah <?=
            Html::activeTextInput($model, "[$key]purch_qty", [
                'data-field' => 'purch_qty',
                'size' => 5, 'id' => false,
                'required' => true])
            ?>
            <?= Html::activeDropDownList($model, "[$key]id_uom", Helper::getProductUomList($model->id_product), ['data-field' => 'id_uom', 'id' => false]) ?>
        </li>
        <li>
            Price Rp <?=
            Html::activeTextInput($model, "[$key]purch_price", [
                'data-field' => 'purch_price',
                'size' => 16, 'id' => false,
                'required' => true])
            ?>
        </li>
    </ul>
</td>
<td class="selling" style="width: 40%">
    <ul class="nav nav-list">
        <li>Selling Price</li>
        <li>
            <?php
            $purch_price = $model->purch_price;
            $sales_price = $model->sales_price;
            $markup = $sales_price > 0 ? 100 * ($sales_price - $purch_price) / $sales_price : 0;
            $markup = round($markup, 2);
            ?>
            Markup <?=
            Html::textInput('', $markup, [
                'data-field' => 'markup_price',
                'size' => 8, 'id' => false,
                'required' => true])
            ?> %
        </li>
        <li>
            Price Rp <?=
            Html::activeTextInput($model, "[$key]sales_price", [
                'data-field' => 'sales_price',
                'size' => 16, 'id' => false,
                'required' => true])
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