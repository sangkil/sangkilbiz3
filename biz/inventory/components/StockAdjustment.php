<?php

namespace biz\inventory\components;

use Yii;
use biz\inventory\models\StockAdjustment as MStockAdjustment;
use biz\inventory\models\StockOpname;
use biz\master\models\ProductStock;
use biz\master\models\ProductUom;

/**
 * Description of StockAdjusment
 *
 * @author Misbahul D Munir (mdmunir) <misbahuldmunir@gmail.com>
 */
class StockAdjustment extends \biz\app\base\ApiHelper
{

    public static function modelClass()
    {
        return MStockAdjustment::className();
    }

    public static function prefixEventName()
    {
        return 'e_stock-adjustment';
    }

    public static function create($data, $model = null)
    {
        $model = $model ? : new MStockAdjustment();
        $e_name = static::prefixEventName();
        $success = false;
        $model->scenario = MStockAdjustment::SCENARIO_DEFAULT;
        $model->load($data, '');
        if (!empty($data['details'])) {
            try {
                $transaction = Yii::$app->db->beginTransaction();
                Yii::$app->trigger($e_name . '_create', new Event([$model]));
                $success = $model->save();
                $success = $model->saveRelated('stockAdjustmentDtls', $data, $success, 'details', MStockAdjustment::SCENARIO_DEFAULT);
                if ($success) {
                    Yii::$app->trigger($e_name . '_created', new Event([$model]));
                    $transaction->commit();
                } else {
                    $transaction->rollBack();
                    if ($model->hasRelatedErrors('stockAdjustmentDtls')) {
                        $model->addError('details', 'Details validation error');
                    }
                }
            } catch (\Exception $exc) {
                $transaction->rollBack();
                throw $exc;
            }
        } else {
            $model->validate();
            $model->addError('details', 'Details cannot be blank');
        }
        return [$success, $model];
    }

    public static function update($id, $data, $model = null)
    {
        $model = $model ? : static::findModel($id);
        $e_name = static::prefixEventName();
        $success = false;
        $model->scenario = MStockAdjustment::SCENARIO_DEFAULT;
        $model->load($data, '');
        if (!isset($data['details']) || $data['details'] !== []) {
            try {
                $transaction = Yii::$app->db->beginTransaction();
                Yii::$app->trigger($e_name . '_update', new Event([$model]));
                $success = $model->save();
                if (!empty($data['details'])) {
                    $success = $model->saveRelated('stockAdjustmentDtls', $data, $success, 'details', MStockAdjustment::SCENARIO_DEFAULT);
                }
                if ($success) {
                    Yii::$app->trigger($e_name . '_updated', new Event([$model]));
                    $transaction->commit();
                } else {
                    $transaction->rollBack();
                    if ($model->hasRelatedErrors('stockAdjustmentDtls')) {
                        $model->addError('details', 'Details validation error');
                    }
                }
            } catch (\Exception $exc) {
                $transaction->rollBack();
                throw $exc;
            }
        } else {
            $model->validate();
            $model->addError('details', 'Details cannot be blank');
        }
        return [$success, $model];
    }

    public static function apply($id, $data = [], $model = null)
    {
        $model = $model ? : static::findModel($id);
        $e_name = static::prefixEventName();
        $success = false;
        $model->scenario = MStockAdjustment::SCENARIO_DEFAULT;
        $model->load($data, '');
        try {
            $transaction = Yii::$app->db->beginTransaction();
            Yii::$app->trigger($e_name . '_apply', new Event([$model]));
            $success = $model->save();
            if ($success) {
                Yii::$app->trigger($e_name . '_applied', new Event([$model]));
                $transaction->commit();
            } else {
                $transaction->rollBack();
                $success = false;
            }
        } catch (\Exception $exc) {
            $transaction->rollBack();
            throw $exc;
        }

        return [$success, $model];
    }

    /**
     * 
     * @param StockOpname $opname
     * @param MStockAdjustment $model
     * @return mixed
     * @throws \Exception
     */
    public static function createFromOpname($opname, $model = null)
    {
        // info product
        $currentStocks = ProductStock::find()->select(['id_product', 'qty_stock'])
                ->where(['id_warehouse' => $opname->id_warehouse])
                ->indexBy('id_product')->asArray()->all();
        $isiProductUoms = [];
        foreach (ProductUom::find()->asArray()->all() as $row) {
            $isiProductUoms[$row['id_product']][$row['id_uom']] = $row['isi'];
        }
        // ***

        $data = [
            'id_warehouse' => $opname->id_warehouse,
            'adjustment_date' => date('Y-m-d'),
            'id_reff' => $opname->id_opname,
            'description' => "Stock adjustment from stock opname no \"{$opname->opname_num}\"."
        ];
        $details = [];
        foreach ($opname->stockOpnameDtls as $detail) {
            $cQty = $currentStocks[$detail->id_product] / $isiProductUoms[$detail->id_product][$detail->id_uom];
            $details[] = [
                'id_product' => $detail->id_product,
                'id_uom' => $detail->id_uom,
                'qty' => $detail->qty - $cQty,
            ];
        }
        $data['details'] = $details;
        return static::create($data, $model);
    }
}