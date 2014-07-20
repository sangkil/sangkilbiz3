<?php

/**
 * @var yii\web\View $this
 * @var biz\models\Purchase $model
 */
$this->title = 'Create Purchase';
$this->params['breadcrumbs'][] = ['label' => 'Purchase', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="purchase-hdr-create">
    <?php
    echo $this->render('_form', [
        'model' => $model,
        'details' => $details,
    ]);
    ?>
</div>
