<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\bootstrap\Modal;
use biz\master\models\ProductUom;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use biz\master\models\Uom;

/* @var $this yii\web\View */
/* @var $model biz\master\models\Product */

$this->title = $model->nm_product;
$this->params['breadcrumbs'][] = ['label' => 'Products', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-view col-lg-6" style="padding-left: 0px;">

    <div class="panel panel-primary">
        <div class="panel-heading">
            Product
        </div>
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
</div>
<div class="col-lg-6">
    <style>
        .tab-content {
            border: 1px #e0e0e0 solid;
            border-top: none;
            padding: 20px;
        }
    </style>

    <?=
    \yii\bootstrap\Tabs::widget([
        'items' => [
            [
                'label' => 'Uoms',
                'content' => GridView::widget([
                    'dataProvider' => new ActiveDataProvider([
                        'query' => $model->getProductUoms()
                        ]),
                    'tableOptions' => ['class' => 'table table-striped'],
                    'layout' => '{items}',
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        'idUom.nm_uom',
                        'idUom.cd_uom',
                        'isi'
                    ],
                ]),
            ],
            [
                'label' => 'Barcode',
                'content' => GridView::widget([
                    'dataProvider' => new ActiveDataProvider([
                        'query' => $model->getBarcodes()
                        ]),
                    'tableOptions' => ['class' => 'table table-striped'],
                    'layout' => '{items}',
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        'barcode',
                    ],
                ]),
            ],
        ]
    ]);
    ?>

    <br>
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

<?php 
Modal::begin([
    'id' => 'myModal',
    'header' => '<h4 class="modal-title">Product Uoms</h4>@' . $model->nm_product
]);
$umodel = new ProductUom;
?>
<?php $form = ActiveForm::begin(); ?>
<div class="modal-body">
    <?= $form->field($umodel, 'id_product')->hiddenInput(['value' => $model->id_product])->label(false) ?>    
    <?= $form->field($umodel, 'id_uom')->dropDownList(ArrayHelper::map(Uom::find()->all(), 'id_uom', 'nm_uom'), ['style' => 'width:200px;']); ?>
    <?= $form->field($umodel, 'isi')->textInput(['style' => 'width:120px;']) ?>
</div>    
<div class="form-group modal-footer" style="text-align: right; padding-bottom: 0px;">
    <?= Html::submitButton($umodel->isNewRecord ? 'Create' : 'Update', ['class' => $umodel->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
</div>
<?php
ActiveForm::end();
Modal::end();
