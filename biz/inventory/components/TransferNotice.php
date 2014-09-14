<?php

namespace biz\inventory\components;

use biz\inventory\models\TransferNotice as MTransferNotice;

/**
 * Description of TransferNotice
 *
 * @author Misbahul D Munir (mdmunir) <misbahuldmunir@gmail.com>
 */
class TransferNotice extends \biz\app\base\ApiHelper
{

    public static function modelClass()
    {
        return MTransferNotice::className();
    }

    public static function prefixEventName()
    {
        return 'e_transfer-notice';
    }

    public static function create($data, $model = null)
    {
        $model = $model ? : new MTransferNotice([
            'notice_date' => date('Y-m-d')
        ]);
        $e_name = static::prefixEventName();
        $success = false;
        $model->scenario = MTransferNotice::SCENARIO_DEFAULT;
        $model->load($data, '');
        if (!empty($data['details'])) {
            try {
                $transaction = Yii::$app->db->beginTransaction();
                Yii::$app->trigger($e_name . '_create', new Event([$model]));
                $success = $model->save();
                $success = $model->saveRelated('stockMovementDtls', $data, $success, 'details', MTransferNotice::SCENARIO_DEFAULT);
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
        throw new \yii\base\NotSupportedException();
    }

    public static function delete($id, $model = null)
    {
        throw new \yii\base\NotSupportedException();
    }
}