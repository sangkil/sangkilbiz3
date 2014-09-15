<?php

namespace biz\master\hooks;

use biz\master\components\Helper as MasterHelper;
use biz\master\models\ProductStock;
use yii\base\UserException;
use biz\master\models\Cogs;

/**
 * Description of Stock
 *
 * @author MDMunir
 */
class StockHook extends \yii\base\Behavior
{

    public function events()
    {
        return [
            'e_stock-movement_created' => 'stockMovement',
            'e_purchase_receive_body' => 'purchaseReceiveBody',
            'e_sales_release_body' => 'salesReleaseBody',
            'e_transfer_release_body' => 'transferReleaseBody',
            'e_transfer_receive_body' => 'transferReceiveBody',
            'e_transfer_complete_body' => 'transferCompleteBody',
            'e_stock-adjustment_applied' => 'adjustmentApplied'
        ];
    }

    /**
     *
     * @param  array         $params
     * Required field id_warehouse, id_product, qty
     * Optional field app, id_ref, id_uom, item_value
     * @return boolean
     * @throws UserException
     */
    public function updateStock($params)
    {
        $stock = ProductStock::findOne([
                'id_warehouse' => $params['id_warehouse'],
                'id_product' => $params['id_product'],
        ]);
        if (isset($params['id_uom'])) {
            $qty_per_uom = MasterHelper::getQtyProductUom($params['id_product'], $params['id_uom']);
        } else {
            $qty_per_uom = 1;
        }

        if (!$stock) {
            $stock = new ProductStock([
                'id_warehouse' => $params['id_warehouse'],
                'id_product' => $params['id_product'],
                'qty_stock' => 0,
            ]);
        }
        // update cogs
        if (isset($params['price'])) {
            $this->updateCogs($params);
        }

        $stock->qty_stock = $stock->qty_stock + $params['qty'] * $qty_per_uom;
        if ($stock->canSetProperty('logParams')) {
            $logParams = ['mv_qty' => $params['qty'] * $qty_per_uom];
            foreach (['app', 'id_ref'] as $key) {
                if (isset($params[$key]) || array_key_exists($key, $params)) {
                    $logParams[$key] = $params[$key];
                }
            }
            $stock->logParams = $logParams;
        }
        if (!$stock->save()) {
            throw new UserException(implode(",\n", $stock->firstErrors));
        }

        return true;
    }

    protected function updateCogs($params)
    {
        $cogs = Cogs::findOne(['id_product' => $params['id_product']]);
        if (!$cogs) {
            $cogs = new Cogs([
                'id_product' => $params['id_product'],
                'cogs' => 0.0
            ]);
        }
        $current_stock = MasterHelper::getCurrentStockAll($params['id_product']);
        $qty_per_uom = MasterHelper::getQtyProductUom($params['id_product'], $params['id_uom']);
        $added_stock = $params['qty'] * $qty_per_uom;
        if ($current_stock + $added_stock != 0) {
            $cogs->cogs = 1.0 * ($cogs->cogs * $current_stock + $params['price'] * $params['qty']) / ($current_stock + $added_stock);
        } else {
            $cogs->cogs = 0;
        }
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
    public function stockMovement($event)
    {
        /* @var $model \biz\inventory\models\StockMovement */
        $model = $event->params[0];
        foreach ($model->stockMovementDtls as $detail) {
            $this->updateStock([
                'id_warehouse' => $detail->id_warehouse,
                'id_product' => $detail->id_product,
                'qty' => $detail->purch_qty,
                'app' => 'stock_movement',
                'price' => $detail->item_value,
                'id_ref' => $detail->id_movement,
            ]);
        }
    }

    /**
     *
     * @param \biz\app\base\Event $event
     */
    public function purchaseReceiveBody($event)
    {
        if (isset($event->sender->stockMovementImplemented)) {
            return;
        }
        /* @var $detail \biz\purchase\models\PurchaseDtl */
        $detail = $event->params[1];
        $this->updateStock([
            'id_warehouse' => $detail->id_warehouse,
            'id_product' => $detail->id_product,
            'id_uom' => $detail->id_uom_receive? : $detail->id_uom,
            'price' => $detail->purch_price,
            'qty' => $detail->qty_receive,
            'app' => 'purchase',
            'id_ref' => $detail->id_purchase_dtl,
        ]);
    }

    /**
     *
     * @param \biz\app\base\Event $event
     */
    public function salesReleaseBody($event)
    {
        if (isset($event->sender->stockMovementImplemented)) {
            return;
        }
        /* @var $detail \biz\sales\models\SalesDtl */
        $detail = $event->params[1];
        $this->updateStock([
            'id_warehouse' => $detail->id_warehouse,
            'id_product' => $detail->id_product,
            'id_uom' => $detail->id_uom_release? : $detail->id_uom,
            'qty' => -$detail->qty_release,
            'app' => 'sales',
            'id_ref' => $detail->id_sales_dtl,
        ]);
    }

    /**
     *
     * @param \biz\app\base\Event $event
     */
    public function transferReleaseBody($event)
    {
        if (isset($event->sender->stockMovementImplemented)) {
            return;
        }
        /* @var $detail \biz\inventory\models\TransferDtl */
        $detail = $event->params[1];
        $this->updateStock([
            'id_warehouse' => $detail->id_warehouse_src,
            'id_product' => $detail->id_product,
            'id_uom' => $detail->id_uom_send? : $detail->id_uom,
            'qty' => -$detail->qty_send,
            'app' => 'transfer_release',
            'id_ref' => $detail->id_transfer,
        ]);
    }

    /**
     *
     * @param \biz\app\base\Event $event
     */
    public function transferReceiveBody($event)
    {
        if (isset($event->sender->stockMovementImplemented)) {
            return;
        }
        /* @var $detail \biz\inventory\models\TransferDtl */
        $detail = $event->params[1];
        $this->updateStock([
            'id_warehouse' => $detail->id_warehouse_dest,
            'id_product' => $detail->id_product,
            'id_uom' => $detail->id_uom_receive? : $detail->id_uom,
            'qty' => $detail->qty_receive,
            'app' => 'transfer_receive',
            'id_ref' => $detail->id_transfer,
        ]);
    }

    /**
     *
     * @param \biz\app\base\Event $event
     */
    public function transferCompleteBody($event)
    {
        if (isset($event->sender->stockMovementImplemented)) {
            return;
        }
        /* @var $detail \biz\inventory\models\TransferDtl */
        $detail = $event->params[1];
        if (!empty($detail->qty_send)) {
            $this->updateStock([
                'id_warehouse' => $detail->id_warehouse_src,
                'id_product' => $detail->id_product,
                'id_uom' => $detail->id_uom_send? : $detail->id_uom,
                'qty' => -$detail->qty_send,
                'app' => 'transfer_complete',
                'id_ref' => $detail->id_transfer,
            ]);
        }
        if (!empty($detail->qty_receive)) {
            $this->updateStock([
                'id_warehouse' => $detail->id_warehouse_dest,
                'id_product' => $detail->id_product,
                'id_uom' => $detail->id_uom_receive? : $detail->id_uom,
                'qty' => $detail->qty_receive,
                'app' => 'transfer_complete',
                'id_ref' => $detail->id_transfer,
            ]);
        }
    }
    

    /**
     * 
     * @param \biz\app\base\Event $event
     */
    public function adjustmentApplied($event)
    {
        if (isset($event->sender->stockMovementImplemented)) {
            return;
        }
        /* @var $model \biz\inventory\models\StockAdjustment */
        $model = $event->params[0];
        foreach ($model->stockAdjustmentDtls as $detail) {
            $this->updateStock([
                'id_warehouse' => $detail->id_warehouse,
                'id_product' => $detail->id_product,
                'qty' => $detail->qty,
                'app' => 'stock_adjustment',
                'price' => $detail->item_value,
                'id_ref' => $detail->id_adjustment,
            ]);
        }
    }
    
}