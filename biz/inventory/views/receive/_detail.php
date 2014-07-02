<?php

use biz\inventory\models\TransferDtl;
use biz\master\components\Helper as MasterHelper;
use yii\jui\AutoComplete;
use yii\web\JsExpression;
use biz\inventory\assets\ReceiveAsset;
use biz\app\assets\BizDataAsset;

/**
 * @var TransferDtl[] $model
 */
?>
<div class="col-lg-9" style="padding-left: 0px;">
    <div class="panel panel-info">
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
            EditableList::widget([
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
ReceiveAsset::register($this);
BizDataAsset::register($this, [
    'master' => MasterHelper::getMasters('product, barcode, product_stock')
]);
$js_ready = <<< JS
\$("#product").data("ui-autocomplete")._renderItem = yii.global.renderItem;
JS;
$this->registerJs($js_ready);
