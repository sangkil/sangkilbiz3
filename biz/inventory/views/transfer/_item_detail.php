<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model biz\inventory\models\TransferDtl */
/* @var $index string */
?>
<td style="width: 50px">
    <a data-action="delete" title="Delete" href="#"><span class="glyphicon glyphicon-trash"></span></a>
    <?= Html::activeHiddenInput($model, "[$index]id_product", ['data-field' => 'id_product', 'id' => false]) ?>
</td>
<td class="items" style="width: 45%">
    <ul class="nav nav-list">
        <li><span class="cd_product"><?= Html::getAttributeValue($model, 'idProduct[cd_product]') ?></span> 
            - <span class="nm_product"><?= Html::getAttributeValue($model, 'idProduct[nm_product]') ?></span></li>
        <li>
            Jumlah <?=
            Html::activeTextInput($model, "[$index]transfer_qty_send", [
                'data-field' => 'transfer_qty_send',
                'size' => 5, 'id' => false,
                'required' => true])
            ?>
            <?= Html::activeDropDownList($model, "[$index]id_uom", Helper::getProductUomList($model->id_product), ['data-field' => 'id_uom', 'id' => false]) ?>
        </li>
        <li>
        </li>
    </ul>
</td>
<td class="selling" style="width: 40%">
    <ul class="nav nav-list">
        <li>Receive</li>
        <li>
            Jumlah <?=
            Html::activeTextInput($model, "[$index]transfer_qty_receive", [
                'data-field' => 'transfer_qty_receive',
                'size' => 5, 'id' => false,
                'readonly' => true])
            ?>
        </li>
        <li>
            Selisih <?php
            $selisih = $model->transfer_qty_receive - $model->transfer_qty_send;
            echo Html::textInput('', $selisih, [
                'data-field' => 'transfer_selisih',
                'size' => 5, 'id' => false,
                'readonly' => true])
            ?>
        </li>
    </ul>
</td>