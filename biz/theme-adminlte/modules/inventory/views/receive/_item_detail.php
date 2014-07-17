<?php

use yii\helpers\Html;
use biz\master\components\Helper;

/* @var $this yii\web\View */
/* @var $model biz\inventory\models\TransferDtl */
/* @var $key string */
?>

<td style="width: 50px">
    <div>
        <?php if ($key === '_key_' || $model->transfer_qty_send == 0): ?>
            <a data-action="delete" title="Delete" href="#" class="pull-right">
                <span class="glyphicon glyphicon-trash"></span>
            </a>
        <?php endif; ?>
        <span class="serial"><?= $key + 1; ?></span>
    </div>
    <?= Html::activeHiddenInput($model, "[$key]id_product", ['data-field' => 'id_product', 'id' => false]) ?>
</td>
<td class="items" style="width: 45%">
    <ul class="nav nav-list">
        <li><span class="cd_product"><?= Html::getAttributeValue($model, 'idProduct[cd_product]') ?></span> 
            - <span class="nm_product"><?= Html::getAttributeValue($model, 'idProduct[nm_product]') ?></span></li>
        <li>
            Jumlah <?=
            Html::activeTextInput($model, "[$key]transfer_qty_send", [
                'data-field' => 'transfer_qty_send',
                'size' => 5, 'id' => false,
                'readonly' => true])
            ?> &nbsp;
            <?php if ($key === '_key_' || $model->transfer_qty_send == 0): ?>
                <?= Html::activeDropDownList($model, "[$key]id_uom", Helper::getProductUomList($model->id_product), ['data-field' => 'id_uom', 'id' => false]) ?>
            <?php else: ?>
                <?= Html::activeHiddenInput($model, "[$key]id_uom"); ?>
                <span ><?= Html::getAttributeValue($model, 'idUom[nm_uom]') ?></span>
            <?php endif; ?>
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
            Html::activeTextInput($model, "[$key]transfer_qty_receive", [
                'data-field' => 'transfer_qty_receive',
                'size' => 5, 'id' => false,
                'value' => is_null($model->transfer_qty_receive) ? $model->transfer_qty_send : $model->transfer_qty_receive,
                'required' => true])
            ?>
        </li>
        <li>
            Selisih <?php
            $selisih = $model->transfer_qty_receive - $model->transfer_qty_send;
            echo Html::textInput('', $selisih, [
                'data-field' => 'transfer_selisih',
                'size' => 5, 'id' => false,
                'readonly' => true, 'disabled' => true])
            ?>
        </li>
    </ul>
</td>
<td class="total-price">
    <ul class="nav nav-list">
        <li>&nbsp;</li>
        <li>

        </li>
    </ul>
</td>
