<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/**
 * @var yii\web\View $this
 * @var biz\models\Warehouse $model
 */
$this->title = 'Warehouse #'.$model->id_warehouse;
$this->params['breadcrumbs'][] = ['label' => 'Warehouses', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="warehouse-view col-lg-8">
    <div class="box box-info">
        <div class="box-body no-padding">
            <?=
            DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'id_warehouse',
                    'id_branch',
                    'cd_whse',
                    'nm_whse',
                    'create_at',
                    'create_by',
                    'update_at',
                    'update_by',
                ],
            ])
            ?>
        </div>
        <div class="box-footer">
            <?= Html::a('Update', ['update', 'id' => $model->id_warehouse], ['class' => 'btn btn-primary']) ?>
            <?=
            Html::a('Delete', ['delete', 'id' => $model->id_warehouse], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ])
            ?>
        </div>
    </div>
</div>
