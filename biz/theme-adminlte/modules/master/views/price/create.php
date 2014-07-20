<?php

/**
 * @var yii\web\View $this
 * @var biz\master\models\Price $model
 */

$this->title = 'Create Price';
$this->params['breadcrumbs'][] = ['label' => 'Prices', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="price-create col-lg-8">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
