<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/**
 * @var yii\web\View $this
 * @var biz\models\AccPeriode $model
 */

$this->title = 'Account Periode #'.$model->id_periode;
$this->params['breadcrumbs'][] = ['label' => 'Acc Periodes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="acc-periode-view col-lg-6">
    <div class="box box-info">
        <div class="box-body no-padding">
            <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id_periode',
            'nm_periode',
            'date_from',
            'date_to',
            'status',
            'create_at',
            'create_by',
            'update_at',
            'update_by',
        ],
    ]) ?>
        </div>
        <div class="box-footer">
             <?= Html::a('Update', ['update', 'id' => $model->id_periode], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id_periode], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
        </div>
    </div>
</div>
