<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/**
 * @var yii\web\View $this
 * @var biz\master\models\ProductSupplier $model
 */
$this->title = $model->id_product;
$this->params['breadcrumbs'][] = ['label' => 'Product Suppliers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-supplier-view col-lg-8">
    <div class="box box-info">
        <div class="box-body">
            <?=
            DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'id_product',
                    'id_supplier',
                    'create_at',
                    'create_by',
                    'update_at',
                    'update_by',
                ],
            ])
            ?>
        </div>
        <div class="box-footer">
            <?= Html::a('Update', ['update', 'id_product' => $model->id_product, 'id_supplier' => $model->id_supplier], ['class' => 'btn btn-primary']) ?>
            <?=
            Html::a('Delete', ['delete', 'id_product' => $model->id_product, 'id_supplier' => $model->id_supplier], [
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
