<?php

use yii\helpers\Html;
use yii\grid\GridView;
use biz\master\models\Uom;
use yii\data\ActiveDataProvider;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model biz\master\models\Product */
?>
<?php
$uoms = \yii\helpers\ArrayHelper::map(Uom::find()->all(), 'id_uom', 'nm_uom');
?>
<?=

GridView::widget([
    'dataProvider' => new ActiveDataProvider([
        'query' => $model->getProductUoms(),
        'sort'=>false,
        ]),
    'tableOptions' => ['class' => 'table table-striped'],
    'layout' => '{items}',
    'showFooter' => true,
    'columns' => [
        [
            'class' => 'yii\grid\SerialColumn',
            'footer' => Html::label('New','#new-uom')
        ],
        [
            'attribute' => 'idUom.nm_uom',
            'footer' => Html::dropDownList('id_uom', '', $uoms, ['style'=>'width:200px;','id'=>'new-uom']),
        ],
        'idUom.cd_uom',
        [
            'attribute' => 'isi',
            'footer' => Html::textInput('isi_uom','',['style'=>'width:50px;'])
        ],
        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{delete}',
            'urlCreator' => function ($action, $uom)use($model) {
                return Url::toRoute(['delete-uom', 'id_product' => $model->id_product, 'id_uom' => $uom->id_uom]);
            }
        ]
    ],
]);
?>

<?php

$js = <<<JS
yii.global.isChangeOrEnter(\$(document),'#input-form [name="id_uom"]',function(){
    \$('#input-form [name="isi_uom"]').focus().select();
});
yii.global.isChangeOrEnter(\$(document),'#input-form [name="isi_uom"]',function(){
    \$('#input-form [name="action"]').val('uom');
    if(\$('#id-uom').val() != ''){
        \$('#input-form').submit();
    }
});
JS;

$this->registerJs($js);