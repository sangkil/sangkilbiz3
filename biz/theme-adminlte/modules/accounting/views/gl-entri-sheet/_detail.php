<?php

use yii\helpers\Html;

/* @var $form yii\widgets\ActiveForm */
/* @var $details biz\models\EntriSheetDtl[] */
/* @var $this yii\web\View */
?>

<?php foreach ($details as $name => $detail): ?>
    <tr>
        <td><?= $name ?></td>
        <td><?= $form->field($detail, "[$name]debit", ['template' => "{input}"]) ?></td>
        <td><?= $form->field($detail, "[$name]kredit", ['template' => "{input}"]) ?></td>
    </tr>
<?php endforeach; ?>