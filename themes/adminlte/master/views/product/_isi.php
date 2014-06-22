<?php
use yii\data\ActiveDataProvider;
use yii\grid\GridView;

echo (!$model->isNewRecord) ? '<a class=" pull-right" data-toggle="modal" data-target="#myModal"><span class="btn glyphicon glyphicon-plus"></span></a>' : '';
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


