<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/**
 * @var yii\web\View $this
 * @var biz\master\models\Category $model
 */
$this->title = 'Category #'.$model->id_category;
$this->params['breadcrumbs'][] = ['label' => 'Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-view col-lg-8">
    <div class="box box-info">
        <div class="box-body no-padding">                
            <?php
            echo DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'id_category',
                    'cd_category',
                    'nm_category',
                    'create_at',
                    'create_by',
                    'update_at',
                    'update_by',
                ],
            ]);
            ?>
        </div>
        <div class="box-footer">
            <?= Html::a('Update', ['update', 'id' => $model->id_category], ['class' => 'btn btn-primary']) ?>
            <?php
            echo Html::a('Delete', ['delete', 'id' => $model->id_category], [
                'class' => 'btn btn-danger',
                'data-confirm' => Yii::t('app', 'Are you sure to delete this item?'),
                'data-method' => 'post',
            ]);
            ?>
        </div>
    </div>
</div>
