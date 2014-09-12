<?php

namespace biz\purchase\components;

use biz\purchase\models\Purchase as MPurchase;
use Yii;
use biz\app\Hooks;
use biz\app\base\Event;

/**
 * Description of Purchase
 *
 * @author Misbahul D Munir (mdmunir) <misbahuldmunir@gmail.com>
 */
class Purchase extends \biz\app\base\ApiHelper
{

    /**
     * 
     * @param mixed $data
     * @return \biz\purchase\models\Purchase
     * @throws \Exception
     */
    public static function create($data)
    {
        $model = new MPurchase([
            'status' => MPurchase::STATUS_DRAFT,
            'id_branch' => Yii::$app->user->branch,
            'purchase_date' => date('Y-m-d')
        ]);
        $e_name = static::prefixEventName();
        $model->scenario = MPurchase::SCENARIO_CREATE;
        $model->load($data, '');
        Yii::$app->trigger($e_name . '_create', new Event([$model]));
        if (!empty($post['details'])) {
            try {
                $transaction = Yii::$app->db->beginTransaction();
                $success = $model->save();
                $success = $model->saveRelated('purchaseDtls', $data, $success, ['PurchaseDtl' => 'details']);
                if ($success) {
                    $transaction->commit();
                } else {
                    $transaction->rollBack();
                }
            } catch (\Exception $exc) {
                $transaction->rollBack();
                throw $exc;
            }
        } else {
            $model->validate();
            $model->addError('details', 'Details cannot be blank');
        }
        return $model;
    }

    public static function update($id, $data)
    {
        $model = static::findModel($id);

        $model->scenario = MPurchase::SCENARIO_UPDATE;
        $model->load($data, '');
        $e_name = static::prefixEventName();
        Yii::$app->trigger($e_name . '_update', new Event([$model]));

        if (!isset($data['details']) || $data['details'] !== []) {
            try {
                $transaction = Yii::$app->db->beginTransaction();
                $success = $model->save();
                if (!empty($data['details'])) {
                    $success = $model->saveRelated('purchaseDtls', $data, $success, ['PurchaseDtl' => 'details']);
                }
                if ($success) {
                    $transaction->commit();
                } else {
                    $transaction->rollBack();
                }
            } catch (\Exception $exc) {
                $transaction->rollBack();
                throw $exc;
            }
        } else {
            $model->validate();
            $model->addError('details', 'Details cannot be blank');
        }
        return $model;
    }

    /**
     * Deletes an existing Purchase model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param  integer $id
     * @return mixed
     */
    public static function delete($id)
    {
        $model = static::findModel($id);
        $e_name = static::prefixEventName();
        Yii::$app->trigger($e_name . '_delete', new Event([$model]));
        return $model->delete();
    }

    public static function modelClass()
    {
        return MPurchase::className();
    }

    public static function receive($id, $data = [])
    {
        $model = static::findModel($id);
        $model->scenario = MPurchase::SCENARIO_RECEIVE;
        $model->load($data, '');
        $e_name = static::prefixEventName();
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $model->status = MPurchase::STATUS_RECEIVE;
            Yii::$app->trigger($e_name . '_receive_1', new Event([$model]));
            if ($model->save()) {
                Yii::$app->trigger($e_name . '_receive_21', new Event([$model]));
                foreach ($model->purchaseDtls as $detail) {
                    Yii::$app->trigger($e_name . '_receive_22', new Event([$model, $detail]));
                }
                Yii::$app->trigger($e_name . '_receive_23', new Event([$model]));
                $transaction->commit();
            } else {
                $transaction->rollBack();
            }
        } catch (Exception $exc) {
            $transaction->rollBack();
            throw $exc;
        }
        return $model;
    }
}