<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var biz\purchase\models\Purchase $model
 */
$this->title = 'Create Sales';
$this->params['breadcrumbs'][] = ['label' => 'Sales', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="purchase-hdr-create">

    <h1><?= Html::encode($this->title) ?></h1>
    <?= Html::dropDownList('', null, $price_category,['id'=>'price_ct']) ?>
    <?php
    echo $this->render('_form', [
        'model' => $model,
        'details' => $details,
        'masters' => $masters,
    ]);
    ?>

</div>
