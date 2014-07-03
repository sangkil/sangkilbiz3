<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\jui\AutoComplete;
use biz\master\models\Uom;
use yii\web\JsExpression;
use yii\data\ActiveDataProvider;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model biz\master\models\Product */
?>
<?php

$uoms = Uom::find()->select(['label' => 'nm_uom', 'value' => 'id_uom'])->asArray()->all();
$onSelect = <<<JS
function(event,ui){
    \$('#input-form [name="isi_uom"]').focus().select();
}
JS;
?>
<?=

GridView::widget([
    'dataProvider' => new ActiveDataProvider([
        'query' => $model->getProductUoms()
        ]),
    'tableOptions' => ['class' => 'table table-striped'],
    'layout' => '{items}',
    'showFooter' => true,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        [
            'attribute' => 'idUom.cd_uom',
            'footer' => AutoComplete::widget([
                'id'=>'id-uom',
                'name' => 'id_uom',
                'clientOptions' => [
                    'source' => $uoms,
                    'select' => new JsExpression($onSelect)
                ]
            ]),
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
yii.global.isChangeOrEnter(\$(document),'#input-form [name="isi_uom"]',function(){
    \$('#input-form [name="action"]').val('uom');
    if(\$('#id-uom').val() != ''){
        \$('#input-form').submit();
    }
});
JS;

$this->registerJs($js);