<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var biz\models\Branch $model
 */
$this->title = 'Create Branch';
$this->params['breadcrumbs'][] = ['label' => 'Branches', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="branch-create col-lg-8">
    <?php
    echo $this->render('_form', [
        'model' => $model,
    ]);
    ?>

</div>
