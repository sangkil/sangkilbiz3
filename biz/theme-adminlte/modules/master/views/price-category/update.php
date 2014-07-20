<?php

/**
 * @var yii\web\View $this
 * @var biz\master\models\PriceCategory $model
 */

$this->title = 'Update Price Category: ' . ' ' . $model->id_price_category;
$this->params['breadcrumbs'][] = ['label' => 'Price Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_price_category, 'url' => ['view', 'id' => $model->id_price_category]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="price-category-update col-lg-8">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
