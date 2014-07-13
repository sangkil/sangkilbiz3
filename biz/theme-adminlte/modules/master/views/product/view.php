<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\Pjax;
use biz\adminlte\MyTabs;

/* @var $this yii\web\View */
/* @var $model biz\master\models\Product */

$this->title = $model->nm_product;
$this->params['breadcrumbs'][] = ['label' => 'Products', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-view col-lg-6" style="padding-left: 0px;">

    <div class="box box-primary">
        <div class="box-header">
            <i class="fa fa-code"></i>
            <h3 class="box-title">Product</h3>
        </div>
        <div class="box-body no-padding">
            <?=
            DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'cd_product',
                    'nm_product',
                    'idCategory.nm_category',
                    'idGroup.nm_group',
                ],
            ])
            ?>
        </div>
        <div class="box-footer">
            <?= Html::a('Update', ['update', 'id' => $model->id_product], ['class' => 'btn btn-primary']) ?>
            <?=
            Html::a('Delete', ['delete', 'id' => $model->id_product], [
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
<div class="col-lg-6">    
    <style>
        .tab-content {
            border: 1px #e0e0e0 solid;
            border-top: none;
            padding: 20px;
        }
    </style>
    <?php
    Pjax::begin([
        'id' => 'pjax',
        'enablePushState' => false,
        'clientOptions' => [
            'url' => \yii\helpers\Url::canonical()
        ]
    ])
    ?>
    <?=
    Html::beginForm('', 'post', [
        'id' => 'input-form',
        'data-pjax' => '#pjax'
    ])
    ?>
    <div class="nav-tabs-custom">
        <?= Html::hiddenInput('action') ?>
        <?=
        MyTabs::widget([
            'contentOption'=>['class'=>'tab-content no-border no-padding'],
            'items' => [
                [
                    'label' => 'Uoms',
                    'content' => $this->render('_form_uom', ['model' => $model]),
                    'active' => $active == 'uom'
                ],
                [
                    'label' => 'Barcode Alias',
                    'content' => $this->render('_form_barcode', ['model' => $model]),
                    'active' => $active == 'barcode',
                ]
            ],
        ]);
        ?>
    </div>
</div>
<?= Html::endForm() ?>
<?php
Pjax::end();
\biz\app\assets\BizAsset::register($this);
