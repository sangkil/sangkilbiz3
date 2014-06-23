<?php

use yii\helpers\Html;
use yii\grid\GridView;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var biz\models\CustomerSearch $searchModel
 */
$this->title = 'Customers';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="customer-index">
    <div class="col-lg-12" style="text-align: right; padding-bottom: 10px;">
        <?= Html::a('', ['create'], ['class' => 'btn btn-warning btn-sm fa fa-plus', 'title' => 'New Supplier']) ?>
    </div>

    <div class=" col-lg-12">
        <div class="box box-info">
            <div class="box-body no-padding">
                <?=
                GridView::widget([
                    'dataProvider' => $dataProvider,
                    'tableOptions' => ['class' => 'table table-striped'],
                    'layout' => '{items}',
                    //'filterModel' => $searchModel,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        //'id_customer',
                        'cd_cust',
                        'nm_cust',
                        'contact_name',
                        'contact_number',
                        // 'status',
                        // 'create_date',
                        // 'create_by',
                        // 'update_date',
                        // 'update_by',
                        ['class' => 'biz\master\components\ActionColumn'],
                    ],
                ]);
                ?>
            </div>        
        </div>
    </div>
</div>