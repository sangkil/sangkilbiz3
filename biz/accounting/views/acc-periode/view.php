<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/**
 * @var yii\web\View $this
 * @var biz\accounting\models\AccPeriode $model
 */

$this->title = $model->nm_periode;
$this->params['breadcrumbs'][] = ['label' => 'Acc Periodes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="acc-periode-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id_periode], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id_periode], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'nm_periode',
            'dateFrom',
            'dateTo',
            'nmStatus',
        ],
    ]) ?>

</div>
