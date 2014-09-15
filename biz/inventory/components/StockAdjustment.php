<?php

namespace biz\inventory\components;

use biz\inventory\models\StockAdjustment as MStockAdjustment;

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
}