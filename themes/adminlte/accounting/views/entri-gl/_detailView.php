<?php
/* @var $model biz\models\GlHeader */
?>
<tr>
    <td colspan="5" style="background-color: whitesmoke; font-weight: bold;"><?= $model->glDate.', '.$model->gl_num ?></td>
</tr>
<?php foreach ($model->glDetails as $rows) { ?>
    <tr>
        <td style="padding-left: 20px;"><?= $rows->idCoa->cd_account ?></td>
        <td><?= $rows->idCoa->nm_account ?></td>
        <td style="text-align: right;"><?php echo ($rows->debit !== '') ? number_format($rows->debit) : '' ?></td>
        <td style="text-align: right;"><?php echo ($rows->kredit !== '') ? number_format($rows->kredit) : '' ?></td>
    </tr>
<?php } ?>
<tr>
    <td style="border-right: none;"></td>
    <td colspan="4" style="border-left: none; font-weight: bold;"><?= $model->description ?></td>
</tr>
