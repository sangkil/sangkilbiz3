<?php
namespace biz\inventory\components;

use biz\inventory\models\StockOpname as MStockOpname;
/**
 * Description of StockOpname
 *
 * @author Misbahul D Munir (mdmunir) <misbahuldmunir@gmail.com>
 */
class StockOpname extends \biz\app\base\ApiHelper
{
    public static function modelClass()
    {
        return MStockOpname::className();
    }
    
    public static function prefixEventName()
    {
        return 'e_stock-opname';
    }
    
    public static function create($data, $model = null)
    {
        $model = $model ? : new MStockOpname();
        $e_name = static::prefixEventName();
        $success = false;
        $model->scenario = MStockOpname::SCENARIO_DEFAULT;
        $model->load($data, '');
        if (!empty($data['details'])) {
            try {
                $transaction = Yii::$app->db->beginTransaction();
                Yii::$app->trigger($e_name . '_create', new Event([$model]));
                $success = $model->save();
                $success = $model->saveRelated('stockMovementDtls', $data, $success, 'details', MStockOpname::SCENARIO_DEFAULT);
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
}