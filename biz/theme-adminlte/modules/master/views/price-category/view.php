<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/**
 * @var yii\web\View $this
 * @var biz\master\models\PriceCategory $model
 */
$this->title = 'Price Category #'.$model->id_price_category;
$this->params['breadcrumbs'][] = ['label' => 'Price Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="price-category-view col-lg-8">
    <div class="box box-primary">
        <div class="box-body no-padding">        
            <?=
            DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'id_price_category',
                    'nm_price_category',
                    'formula',
                    'create_by',
                    'update_at',
                    'update_by',
                    'create_at',
                ],
            ])
            ?>
        </div>
        <div class="box-footer">
            <?= Html::a('Update', ['update', 'id' => $model->id_price_category], ['class' => 'btn btn-primary']) ?>
            <?=
            Html::a('Delete', ['delete', 'id' => $model->id_price_category], [
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
