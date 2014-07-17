<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/**
 * @var yii\web\View $this
 * @var biz\master\models\Price $model
 */
$this->title = 'Product Price #'.$model->id_product;
$this->params['breadcrumbs'][] = ['label' => 'Prices', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="price-view col-lg-8">
    <div class="box box-info">
        <div class="box-body no-padding">
            <?=
            DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'id_product',
                    'idProduct.cd_product',
                    'idProduct.nm_product',
                    'id_price_category',
                    'idPriceCategory.nm_price_category',
                    'id_uom',
                    'price',
                    'create_at',
                    'create_by',
                    'update_at',
                    'update_by',
                ],
            ])
            ?>
        </div>
        <div class="box-footer">
            <?= Html::a('Update', ['update', 'id_product' => $model->id_product, 'id_price_category' => $model->id_price_category], ['class' => 'btn btn-primary']) ?>
            <?=
            Html::a('Delete', ['delete', 'id_product' => $model->id_product, 'id_price_category' => $model->id_price_category], [
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
