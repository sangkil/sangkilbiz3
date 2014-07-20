<?php

use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\widgets\LinkPager;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var biz\models\searchs\TransferNotice $searchModel
 */
$this->title = 'Transfer Notices';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="transfer-notice-index">
    <div class="col-lg-4" style="float: right;">
        <?php echo $this->render('_search', ['model' => $searchModel]); ?>
    </div>
    <div class="col-lg-12">
        <?php Pjax::begin(['formSelector' => 'form', 'enablePushState' => false]); ?>
        <div class="box box-danger">
            <div class="box-body no-padding">
                <?php
                echo GridView::widget([
                    'dataProvider' => $dataProvider,
                    'tableOptions' => ['class' => 'table table-striped'],
                    'layout' => '{items}',
                    //'filterModel' => $searchModel,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        'idProduct.nm_product','id_warehouse',
                        'mv_qty', 'qty_stock', 'id_uom', 'app',
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
        Pjax::end();
        ?>
    </div>
</div>
