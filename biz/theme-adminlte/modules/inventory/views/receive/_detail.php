<?php

use biz\inventory\models\TransferDtl;
use yii\jui\AutoComplete;
use yii\web\JsExpression;
use biz\app\assets\BizDataAsset;
use mdm\widgets\TabularInput;
use biz\master\components\Helper as MasterHelper;

/**
 * @var TransferDtl[] $model
 */
?>
<div class="box box-info">
    <div class="box-body no-padding">
        <table class="table table-striped">
            <tfoot>
                <tr>
                    <td colspan="4">
                        Product :
                        <?php
                        echo AutoComplete::widget([
                            'name' => 'product',
                            'id' => 'product',
                            'clientOptions' => [
                                'source' => new JsExpression('yii.global.sourceProduct'),
                                'select' => new JsExpression('yii.receive.onProductSelect'),
                                'delay' => 100,
                            ]
                        ]);
                        ?>
                    </td>
                </tr>
            </tfoot>
            <?=
            TabularInput::widget([
                'id' => 'detail-grid',
                'allModels' => $details,
                'modelClass' => TransferDtl::className(),
                'itemView' => '_item_detail',
                'options' => ['tag' => 'tbody'],
                'itemOptions' => ['tag' => 'tr'],
            ])
            ?>
        </table>
    </div>
</div>

<?php
$js = $this->render('_script',[],$this->context);
$this->registerJs($js, yii\web\View::POS_END);
BizDataAsset::register($this, [
    'master' => MasterHelper::getMasters('product, barcode, product_stock')
]);
$js_ready = <<< JS
\$("#product").data("ui-autocomplete")._renderItem = yii.global.renderItem;
yii.receive.onReady();
JS;
$this->registerJs($js_ready);
