<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;

/**
 * @var yii\web\View $this
 * @var biz\models\Product $model
 */
$this->title = 'Product #' . $model->id_product;
$this->params['breadcrumbs'][] = ['label' => 'Products', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class=" product col-lg-7">
    <div class="box box-danger">
        <div class="box-header">
            <h3 class="box-title">Product</h3>
        </div>
        <div class="box-body no-padding">            
            <?=
            DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'id_product',
                    'cd_product',
                    'nm_product',
                    'id_category',
                    'id_group',
                    'create_date',
                    'create_by',
                    'update_date',
                    'update_by',
                ],
            ])
            ?>
        </div>
    </div>
</div>
<div class="col-lg-5">
    <!-- Nav tabs -->
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
            <li class="active btn-finish"><a href="#uoms" data-toggle="tab">Uoms</a></li>
            <li><a href="#aliases" data-toggle="tab">Aliases</a></li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="uoms">
                <?php
                if ($model->isNewRecord):
                    echo $form->field($model, 'productUoms[id_uom]')->dropDownList(ArrayHelper::map(Uom::find()->all(), 'id_uom', 'nm_uom'), ['style' => 'width:200px;']);
                    echo $form->field($model, 'productUoms[isi]')->textInput(['style' => 'width:120px;']);
                else:
                    $dPro = new ActiveDataProvider([
                        'query' => $model->getProductUoms(),
                        'pagination' => [
                            'pageSize' => 10,
                        ],
                    ]);

                    echo GridView::widget([
                        'dataProvider' => $dPro,
                        'tableOptions' => ['class' => 'table table-striped'],
                        'layout' => '{items}',
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],
                            'idUom.nm_uom',
                            'idUom.cd_uom',
                            'isi'
                        ],
                    ]);
                endif;
                ?>
            </div>
            <div class="tab-pane" id="aliases"></div>
        </div>
    </div>
    <!-- Tab panes -->


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

