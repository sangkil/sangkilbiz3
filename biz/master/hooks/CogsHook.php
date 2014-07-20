<?php

namespace biz\master\hooks;

use biz\app\Hooks;
use biz\master\components\Helper;
use biz\master\models\Cogs;
use yii\base\UserException;

/**
 * Description of Cogs
 *
 * @author MDMunir
 */
class CogsHook extends \yii\base\Behavior
{

    public function events()
    {
        return [
            Hooks::E_PPREC_22 => 'purchaseReceiveBody'
        ];
    }

    protected function updateCogs($params)
    {
        $cogs = Cogs::findOne(['id_product' => $params['id_product']]);
        if (!$cogs) {
            $smallest_uom = Helper::getSmallestProductUom($params['id_product']);
            $cogs = new Cogs();
            $cogs->setAttributes([
                'id_product' => $params['id_product'],
                'id_uom' => $smallest_uom,
                'cogs' => 0.0
            ]);
        }
        $current_stock = Helper::getCurrentStockAll($params['id_product']);
        $qty_per_uom = Helper::getQtyProductUom($params['id_product'], $params['id_uom']);
        $added_stock = $params['added_stock'] * $qty_per_uom;
        $cogs->cogs = 1.0 * ($cogs->cogs * $current_stock + $params['price'] * $params['added_stock']) / ($current_stock + $added_stock);
        if ($cogs->canSetProperty('logParams')) {
            $cogs->logParams = [
                'app' => $params['app'],
                'id_ref' => $params['id_ref'],
            ];
        }
        if (!$cogs->save()) {
            throw new UserException(implode(",\n", $cogs->firstErrors));
        }

        return true;
    }

    /**
     *
     * @param \biz\app\base\Event $event
     */
    public function purchaseReceiveBody($event)
    {
        /* @var $model \biz\master\models\Purchase */
        /* @var $detail \biz\master\models\PurchaseDtl */
        $model = $event->params[0];
        $detail = $event->params[1];
        $this->updateCogs([
            'id_product' => $detail->id_product,
            'id_uom' => $detail->id_uom,
            'added_stock' => $detail->purch_qty,
            'price' => ($detail->purch_price * (1 - $model->item_discount * 0.01)),
            'app' => 'purchase',
            'id_ref' => $detail->id_purchase_dtl,
        ]);
    }
}
