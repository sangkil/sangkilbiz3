<?php

/**
 * @var yii\web\View $this
 * @var biz\master\models\ProductSupplier $model
 */

$this->title = 'Create Product Supplier';
$this->params['breadcrumbs'][] = ['label' => 'Product Suppliers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-supplier-create col-lg-8">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
