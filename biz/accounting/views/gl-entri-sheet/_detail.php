<?php

use yii\helpers\Html;

/* @var $form yii\widgets\ActiveForm */
/* @var $model biz\accounting\models\GlDetail */
/* @var $key string */
/* @var $this yii\web\View */
?>
<td>
<?= $key ?>
    <?= Html::activeHiddenInput($model, "[$key]id_coa") ?>
</td>
<td><?= Html::activeTextInput($model, "[$key]debit", ['class'=>'amount','style'=>'text-align:right'])?></td>
<td><?= Html::activeTextInput($model, "[$key]kredit", ['class'=>'amount','style'=>'text-align:right']) ?></td>
