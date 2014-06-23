<?php

use yii\grid\GridView;
use yii\widgets\LinkPager;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var biz\models\ProductStockSearch $searchModel
 */
$this->title = 'Product Stocks';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-stock-index">
    <div class="col-lg-4" style="float: right;">
        <?php echo $this->render('_search', ['model' => $searchModel]); ?> 
    </div>
    <div class="col-lg-12">
        <?php //Pjax::begin(['formSelector' => 'form', 'enablePushState' => false]); ?>
        <div class="box box-danger">
            <div class="box-body no-padding">
                <?=
                GridView::widget([
                    'tableOptions' => ['class' => 'table table-striped'],
                    'layout' => '{items}',
                    'dataProvider' => $dataProvider,
                    //'filterModel' => $searchModel,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        'idWarehouse.nm_whse',
                        'idProduct.nm_product',
                        'qty_stock',
                        'idUom.cd_uom',
                    //'create_date',
                    // 'create_by',
                    // 'update_date',
                    // 'update_by',
                    //['class' => 'biz\master\components\ActionColumn'],
                    ],
                ]);
                ?>
            </div>           
        </div>
        <?php
        // display pagination
        echo LinkPager::widget([
            'pagination' => $dataProvider->pagination,
            'options' => ['class' => 'pagination pagination-sm no-margin']
        ]);
        ?>
        <?php //Pjax::end(); ?>
    </div>   
</div>
<?php
$js = "\$('#kecilin').click();";
$this->registerJs($js);

