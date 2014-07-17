<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model biz\master\models\ProductUom */

$this->title = 'Create Product Uom';
$this->params['breadcrumbs'][] = ['label' => 'Product Uoms', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-uom-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
