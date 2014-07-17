<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var biz\master\models\PriceCategory $model
 */

$this->title = 'Create Price Category';
$this->params['breadcrumbs'][] = ['label' => 'Price Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="price-category-create col-lg-8">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
