<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var biz\models\searchs\Invoice $searchModel
 */
$this->title = 'Invoice Hdrs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="invoice-hdr-index">
    <?php \yii\widgets\Pjax::begin(['enablePushState' => false]); ?>
    <?php
    $form = ActiveForm::begin([
            'method' => 'post',
    ]);
    ?>
    <div class="box box-info">
        <div class="box-body">
            <div class="form-group" style="text-align: right;">
                <?php
                echo Html::label('Selected Amount', '') . '<br>';
                echo Html::label('Rp0.00', '', ['id' => 'RSelected', 'style' => 'font-size: x-large']);
                echo Html::hiddenInput('selectedId', '', ['id' => 'selectedId']);
                ?>
            </div>
        </div>
        <?php
        echo GridView::widget([
            'id' => 'inv_grid',
            'dataProvider' => $dataProvider,
            'showFooter' => true, 'tableOptions' => ['class' => 'table table-striped'],
            'layout' => '{items}',
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                //'id_invoice',
                'invoice_num',
//                ['class' => 'yii\grid\DataColumn',
//                    'attribute' => 'invoiceDtl.idPurchase.purchase_num',
//                    'filter' => Html::activeTextInput($searchModel, 'purc_num', ['class' => 'form-control'])
//                ],
//                'idSupplier.nm_supplier',
                //'invDate',
                'dueDate',
                //'id_vendor',
                ['class' => 'yii\grid\DataColumn',
                    'header' => 'Nilai Invoice',
                    'attribute' => 'invoice_value',
                    'format' => 'number',
                    'footer' => number_format($jmlInv),
                    'footerOptions' => ['style' => 'text-align:right; font-weight: bold;'],
                    'contentOptions' => ['style' => 'text-align:right;']],
                ['class' => 'yii\grid\DataColumn',
                    'header' => 'Di Bayar',
                    'attribute' => 'paid',
                    'format' => 'number',
                    'footer' => number_format($jmlPaid),
                    'footerOptions' => ['style' => 'text-align:right; font-weight: bold;'],
                    'contentOptions' => ['style' => 'text-align:right;']],
                [
                    'class' => 'yii\grid\DataColumn',
                    'header' => 'Sisa Harus diBayar',
                    'attribute' => 'sisaBayar',
                    'format' => 'number',
                    'footer' => number_format($jmlRemain),
                    'footerOptions' => ['style' => 'text-align:right; font-weight: bold;'],
                    'contentOptions' => ['style' => 'text-align:right;', 'class' => 'sisa-bayar']
                ],
                [
                    'class' => 'yii\grid\CheckboxColumn',
                    'checkboxOptions' => ['class' => 'ck-list'],
                ],
            ],
        ]);
        ?>
        <div class="box-footer">
            <?= Html::a('Execute', ['create','type'=>$type], ['class' => 'btn btn-success','id'=>'btn-execute']) ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
    <?php \yii\widgets\Pjax::end(); ?>
</div>
<?php
$createUrl = \yii\helpers\Url::to(['create','type'=>$type]);
$js = <<<JS
\$(document).off('click.biz','input.ck-list, input.select-on-check-all').on('click.biz','input.ck-list, input.select-on-check-all',function () {
    var total = 0.0;
    var \$ck = \$(this);
    \$('#inv_grid input.ck-list:checked').each(function () {
        var \$tr = \$(this).closest('#inv_grid tr[data-key]');
        var remain = \$tr.children('td.sisa-bayar').text().split(',').join('');
        total += Number(remain);
    });
    \$('#RSelected').html('Rp'+numeral(total).format('0,0'));
    if (\$ck.is('input.ck-list')) {
        var all = \$('input.ck-list').length == \$('input.ck-list:checked').length;
        \$('input.select-on-check-all').prop('checked',all);
    }
    var url = '{$createUrl}&ids=';
    var ids = \$('#inv_grid').yiiGridView('getSelectedRows').join(',');
    \$('#btn-execute').attr('href',url+ids);
});
JS;
biz\app\assets\BizAsset::register($this);
$this->registerJs($js);
