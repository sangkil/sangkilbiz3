<?php

/**
 * @var yii\web\View $this
 * @var biz\purchase\models\Purchase $model
 */
$this->title = 'Create Transfer';
$this->params['breadcrumbs'][] = ['label' => 'Transfer', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="purchase-hdr-create">
    <?php
    echo $this->render('_form', [
        'model' => $model,
    ]);
    ?>

</div>
