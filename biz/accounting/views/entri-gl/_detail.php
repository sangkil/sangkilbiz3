<?php

use yii\helpers\Html

/* @var $model biz\accounting\models\GlDetail */
/* @var $index string */
?>
<?= Html::activeHiddenInput($model, "[$index]id_gl_detail") ?>
<td ><span class="serial"><?= $index ?></span></td>
<td>
    <?= Html::activeHiddenInput($model, "[$index]id_coa", ['class' => 'id_account']) ?>
    <?= Html::activeTextInput($model, "[$index]idCoa[nm_account]", ['class' => 'nm_account', 'style' => 'width:260px']) ?>&nbsp;
    <span class="cd_account"><?= \yii\helpers\ArrayHelper::getValue($model, 'idCoa.cd_account'); ?></span>
</td>
<td><?=
    Html::activeTextInput($model, "[$index]debit", [
        'style' => 'width:90px;text-align:right;',
        'class' => 'amount'
    ])
    ?></td>
<td><?=
    Html::activeTextInput($model, "[$index]kredit", [
        'style' => 'width:90px;text-align:right;',
        'class' => 'amount'
    ])
    ?></td>
<td class="action">
    <a class="fa fa-minus-square-o" href="#" data-action="delete">
        <span class="glyphicon glyphicon-trash"></span>
    </a>
</td>
