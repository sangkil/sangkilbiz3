<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var biz\models\AccPeriode $model
 */
$this->title = 'Create Acc Periode';
$this->params['breadcrumbs'][] = ['label' => 'Acc Periodes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="acc-periode-create">
    <?=
    $this->render('_form', [
        'model' => $model,
    ])
    ?>
</div>
