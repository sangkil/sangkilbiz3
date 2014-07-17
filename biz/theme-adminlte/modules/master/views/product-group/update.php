<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var biz\master\models\ProductGroup $model
 */

$this->title = 'Update Product Group: ' . ' ' . $model->id_group;
$this->params['breadcrumbs'][] = ['label' => 'Product Groups', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_group, 'url' => ['view', 'id' => $model->id_group]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="product-group-update col-lg-8">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
