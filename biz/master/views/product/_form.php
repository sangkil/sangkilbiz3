<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use biz\master\models\Category;
use biz\master\models\ProductGroup;
use yii\bootstrap\Modal;
use biz\master\models\Uom;
use biz\master\models\ProductUom;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\bootstrap\Tabs;

/**
 * @var yii\web\View $this
 * @var biz\master\models\Product $model
 * @var yii\widgets\ActiveForm $form
 */
?>
<style>
    .tab-content {
        border: 1px #e0e0e0 solid;
        border-top: none;
        padding: 20px;
    }

    .modal-header {
        background-color: #428BCA;
        border-color: #428BCA;
        color: #FFFFFF;
    }
</style>
<?php $form = ActiveForm::begin(); ?>
<div class=" product col-lg-6">

    <div class="panel panel-primary">
        <div class="panel-heading">
            Product
        </div>
        <div class="panel-body">

            <?= $form->field($model, 'cd_product')->textInput(['maxlength' => 13, 'style' => 'width:160px;']) ?>

            <?= $form->field($model, 'nm_product')->textInput(['maxlength' => 64]) ?>

            <?= $form->field($model, 'id_category')->dropDownList(ArrayHelper::map(Category::find()->all(), 'id_category', 'nm_category'), ['style' => 'width:200px;']); ?>

            <?= $form->field($model, 'id_group')->dropDownList(ArrayHelper::map(ProductGroup::find()->all(), 'id_group', 'nm_group'), ['style' => 'width:200px;']); ?>

        </div>   
        <div class="panel-footer">
            <div class="form-group">
                <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            </div>
        </div>
    </div>
</div>
<style>
    .tab-content {
        border: 1px #e0e0e0 solid;
        border-top: none;
        padding: 20px;
    }
</style>
<div class="col-lg-6">
    <?=
    Tabs::widget([
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
    </div>
<?php
ActiveForm::end();
