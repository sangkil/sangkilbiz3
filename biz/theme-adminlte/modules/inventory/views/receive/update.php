<?php

/**
 * @var yii\web\View $this
 * @var biz\purchase\models\Purchase $model
 */
$this->title = 'Receive: ' . $model->transfer_num;
$this->params['breadcrumbs'][] = ['label' => 'Receive', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->transfer_num, 'url' => ['view', 'id' => $model->id_transfer]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="purchase-hdr-update">
    <?php
    echo $this->render('_form', [
        'model' => $model,
        'details' => $details,
    ]);
    ?>

</div>
