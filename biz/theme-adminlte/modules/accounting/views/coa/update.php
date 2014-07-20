<?php

/**
 * @var yii\web\View $this
 * @var biz\models\Coa $model
 */

$this->title = 'Update Coa: ' . ' ' . $model->id_coa;
$this->params['breadcrumbs'][] = ['label' => 'Coas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_coa, 'url' => ['view', 'id' => $model->id_coa]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="coa-update col-lg-6">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
