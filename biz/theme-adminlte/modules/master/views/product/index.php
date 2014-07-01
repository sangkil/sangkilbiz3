<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\LinkPager;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var biz\models\ProductSearch $searchModel
 */
$this->title = 'Products';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-index">
    <div class="col-lg-4" style="float: right;">
        <?php echo $this->render('_search', ['model' => $searchModel]); ?> 
    </div>
    <div class="col-lg-12">
        <?php //Pjax::begin(['formSelector' => 'form', 'enablePushState' => false]); ?>
        <div class="box box-danger">
            <div class="box-body no-padding">
                <?=
                GridView::widget([
                    'dataProvider' => $dataProvider,
                    'tableOptions' => ['class' => 'table table-striped'],
                    'layout' => '{items}',
                    //'filterModel' => $searchModel,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        //'id_product',
                        'cd_product',
                        'nm_product',
                        'idCategory.nm_category',
                        //'id_category',
                        'idGroup.nm_group',
                        //'id_group',
                        // 'create_at',
                        // 'create_by',
                        // 'update_at',
                        // 'update_by',
                        ['class' => 'biz\app\components\ActionColumn'],
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
