<?php

namespace biz\accounting\components;

use biz\accounting\models\GlHeader;
/**
 * Description of GL
 *
 * @author Misbahul D Munir (mdmunir) <misbahuldmunir@gmail.com>
 */
class GL extends \biz\app\base\ApiHelper
{
    public static function modelClass()
    {
        return GlHeader::className();
    }
    
    public static function prefixEventName()
    {
        return 'e_gl';
    }
    
    public static function create($data, $model = null)
    {
        $model = $model ? : new GlHeader();
        $e_name = static::prefixEventName();
        $success = false;
        $model->scenario = GlHeader::SCENARIO_DEFAULT;
        $model->load($data, '');
        if (!empty($data['details'])) {
            try {
                $transaction = Yii::$app->db->beginTransaction();
                Yii::$app->trigger($e_name . '_create', new Event([$model]));
                $success = $model->save();
                $success = $model->saveRelated('stockAdjustmentDtls', $data, $success, 'details');
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
}