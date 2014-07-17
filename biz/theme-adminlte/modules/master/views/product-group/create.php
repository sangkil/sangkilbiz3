<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var biz\master\models\ProductGroup $model
 */

$this->title = 'Create Product Group';
$this->params['breadcrumbs'][] = ['label' => 'Product Groups', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-group-create col-lg-8">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
