<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var biz\models\AccPeriode $model
 */

$this->title = 'Update Acc Periode: ' . ' ' . $model->id_periode;
$this->params['breadcrumbs'][] = ['label' => 'Acc Periodes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_periode, 'url' => ['view', 'id' => $model->id_periode]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="acc-periode-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
