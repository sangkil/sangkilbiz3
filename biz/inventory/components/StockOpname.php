<?php

namespace biz\inventory\components;

use Yii;
use biz\inventory\models\StockOpname as MStockOpname;
use biz\inventory\models\StockOpnameDtl;
use yii\helpers\ArrayHelper;
use biz\app\base\Event;

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

    public static function append($id, $data, $model = null)
    {
        /* @var $model MStockOpname */
        $model = $model ? : static::findModel($id);
        $e_name = static::prefixEventName();
        $success = true;
        $model->scenario = MStockOpname::SCENARIO_DEFAULT;
        $model->load($data, '');
        try {
            $transaction = Yii::$app->db->beginTransaction();
            Yii::$app->trigger($e_name . '_append', new Event([$model]));
            $stockOpnameDtls = ArrayHelper::index($model->stockOpnameDtls, 'id_product');
            foreach ($data['details'] as $dataDetail) {
                $index = $dataDetail['id_product']; // id_product
                if (isset($stockOpnameDtls[$index])) {
                    $detail = $stockOpnameDtls[$index];
                } else {
                    $detail = new StockOpnameDtl([
                        'id_opname' => $model->id_opname,
                        'id_product' => $dataDetail['id_product'],
                        'id_uom' => $dataDetail['id_uom'],
                        'qty' => 0
                    ]);
                }
                $detail->qty += $dataDetail['qty'];
                $success = $success && $detail->save();
                $stockOpnameDtls[$index] = $detail;
                Yii::$app->trigger($e_name . '_append_body', new Event([$model, $detail]));
            }
            if ($success) {
                Yii::$app->trigger($e_name . '_appended', new Event([$model]));
                $transaction->commit();
            } else {
                $transaction->rollBack();
            }
        } catch (\Exception $exc) {
            $transaction->rollBack();
            throw $exc;
        }
        return [$success, $model];
    }
}