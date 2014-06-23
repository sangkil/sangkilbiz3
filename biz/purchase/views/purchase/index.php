<?php

use yii\helpers\Html;
use yii\grid\GridView;
use biz\purchase\models\PurchaseHdr;
use biz\master\tools\Helper;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var biz\purchase\models\PurchaseHdrSearch $searchModel
 */
$this->title = 'Purchase Hdrs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="purchase-hdr-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="pull-right">
        <?= Html::a('', ['create'], ['class' => 'btn btn-default glyphicon glyphicon-plus', 'title' => 'Create New', 'style' => 'width:100%;']) ?>
    </div>

    <?php yii\widgets\Pjax::begin(['formSelector' => 'form', 'enablePushState' => false]); ?>
    <?php
    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'tableOptions' => ['class' => 'table table-striped'],
        'layout' => '{items}{pager}',
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'purchase_num',
            'idSupplier.nm_supplier',
            'idBranch.nm_branch',
            'purchaseDate',
            'nmStatus',
            [
                'class' => 'biz\master\components\ActionColumn',
                'template' => '{view} {update} {delete} {receive} {posting}',
                'buttons' => [
                    'receive' => function ($url, $model) {
                    if (Helper::checkAccess('receive', $model)) {
                        return Html::a('<span class="glyphicon glyphicon-save"></span>', $url, [
                                'title' => Yii::t('yii', 'Receive'),
                                'data-confirm' => Yii::t('yii', 'Are you sure you want to Receive this item?'),
                                'data-method' => 'post',
                                'data-pjax' => '0',
                        ]);
                    }
                },
                    'posting' => function ($url, $model) {
                    if (Helper::checkAccess('posting', $model)) {
                        return Html::a('<span class="glyphicon glyphicon-open"></span>', $url, [
                                'title' => Yii::t('yii', 'Posting'),
                                'data-confirm' => Yii::t('yii', 'Are you sure you want to Posting this item?'),
                                'data-method' => 'post',
                                'data-pjax' => '0',
                        ]);
                    }
                },
                ]
            ],
        ],
    ]);
    ?>
    <?php yii\widgets\Pjax::end(); ?>
</div>
<?php
$js = "\$(document).on('pjax:error', function(e,xhr) {
  alert(xhr.responseText);
})";
$this->registerJs($js);
