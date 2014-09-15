<?php

namespace biz\inventory\components;

use Yii;
use biz\inventory\models\StockMovement as MStockMovement;
use biz\app\base\Event;
use yii\base\NotSupportedException;

/**
 * Description of StockMovement
 *
 * @author Misbahul D Munir (mdmunir) <misbahuldmunir@gmail.com>
 */
class StockMovement extends \biz\app\base\ApiHelper
{

    public static function modelClass()
    {
        return MStockMovement::className();
    }

    public static function prefixEventName()
    {
        return 'e_stock-movement';
    }

    public static function create($data, $model = null)
    {
        $model = $model ? : new MStockMovement();
        $e_name = static::prefixEventName();
        $success = false;
        $model->scenario = MStockMovement::SCENARIO_DEFAULT;
        $model->load($data, '');
        if (!empty($data['details'])) {
            try {
                $transaction = Yii::$app->db->beginTransaction();
                Yii::$app->trigger($e_name . '_create', new Event([$model]));
                $success = $model->save();
                $success = $model->saveRelated('stockMovementDtls', $data, $success, 'details', MStockMovement::SCENARIO_DEFAULT);
                if ($success) {
                    Yii::$app->trigger($e_name . '_created', new Event([$model]));
                    $transaction->commit();
                } else {
                    $transaction->rollBack();
                    if ($model->hasRelatedErrors('stockMovementDtls')) {
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
        throw new NotSupportedException();
    }
    
    public static function delete($id, $model = null)
    {
        throw new NotSupportedException();
    }
}