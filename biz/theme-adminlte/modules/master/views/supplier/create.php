<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var biz\models\Supplier $model
 */

$this->title = 'Create Supplier';
$this->params['breadcrumbs'][] = ['label' => 'Suppliers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="supplier-create col-lg-8">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
