<?php

use yii\helpers\Html

/* @var $model biz\accounting\models\EntriSheetDtl */
/* @var $key string */
?>
<td ><span class="serial"><?= $key+1 ?></span></td>
<td><?=
    Html::activeTextInput($model, "[$key]nm_esheet_dtl", [
        'style' => 'width:190px;',
    ])
    ?>
</td>
<td>
    <?= Html::activeHiddenInput($model, "[$key]id_coa", ['class' => 'id_account']) ?>
    <?= Html::activeTextInput($model, "[$key]idCoa[nm_account]", ['class' => 'nm_account', 'style' => 'width:260px']) ?>&nbsp;
    <span class="cd_account"><?= \yii\helpers\ArrayHelper::getValue($model, 'idCoa.cd_account'); ?></span>
</td>
<td class="action">
    <a class="fa fa-minus-square-o" href="#" data-action="delete">
        <span class="glyphicon glyphicon-trash"></span>
    </a>
</td>
