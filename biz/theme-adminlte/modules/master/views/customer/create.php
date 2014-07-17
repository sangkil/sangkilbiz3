<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var biz\models\Customer $model
 */
$this->title = 'Create Customer';
$this->params['breadcrumbs'][] = ['label' => 'Customers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="customer-create col-lg-8">
    <?=
    $this->render('_form', [
        'model' => $model,
    ])
    ?>

</div>
