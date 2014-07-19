<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/**
 * @var yii\web\View $this
 * @var biz\models\Supplier $model
 */
$this->title = 'Supplier #'.$model->id_supplier;
$this->params['breadcrumbs'][] = ['label' => 'Suppliers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="supplier-view col-lg-8">

    <div class="box box-primary">
        <div class="box-header">
            <i class="fa fa-users"></i>
            <h3 class="box-title">Suppliers</h3>
        </div>
        <div class="box-body no-padding">
            <?=
            DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'id_supplier',
                    'cd_supplier',
                    'nm_supplier',
                    'create_at',
                    'create_by',
                    'update_at',
                    'update_by',
                ],
            ])
            ?>
        </div>

        <div class="box-footer">
            <?= Html::a('Update', ['update', 'id' => $model->id_supplier], ['class' => 'btn btn-primary']) ?>
            <?=
            Html::a('Delete', ['delete', 'id' => $model->id_supplier], [
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
