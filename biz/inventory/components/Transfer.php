<?php

namespace biz\inventory\components;

use biz\inventory\models\Transfer as MTransfer;
use biz\inventory\models\TransferDtl;
use yii\helpers\ArrayHelper;

/**
 * Description of InventoryTransfer
 *
 * @author Misbahul D Munir (mdmunir) <misbahuldmunir@gmail.com>
 */
class Transfer extends \biz\app\base\ApiHelper
{

    public static function modelClass()
    {
        return MTransfer::className();
    }

    public static function prefixEventName()
    {
        return 'e_transfer';
    }

    public static function create($data, $model = null)
    {
        $model = $model ? : new MTransfer([
            'status' => MTransfer::STATUS_DRAFT,
            'id_branch' => Yii::$app->user->branch,
            'transfer_date' => date('Y-m-d')
        ]);
        $e_name = static::prefixEventName();
        $success = false;
        $model->scenario = MTransfer::SCENARIO_DEFAULT;
        $model->load($data, '');

        if (!empty($data['details'])) {
            try {
                $transaction = Yii::$app->db->beginTransaction();
                Yii::$app->trigger($e_name . '_create', new Event([$model]));
                $success = $model->save();
                $success = $model->saveRelated('transferDtls', $data, $success, 'details', MTransfer::SCENARIO_DEFAULT);
                if ($success) {
                    Yii::$app->trigger($e_name . '_created', new Event([$model]));
                    $transaction->commit();
                } else {
                    $transaction->rollBack();
                    if ($model->hasRelatedErrors('transferDtls')) {
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
        $model->scenario = MTransfer::SCENARIO_DEFAULT;
        $model->load($data, '');

        if (!isset($data['details']) || $data['details'] !== []) {
            try {
                $transaction = Yii::$app->db->beginTransaction();
                Yii::$app->trigger($e_name . '_update', new Event([$model]));
                $success = $model->save();
                if (!empty($data['details'])) {
                    $success = $model->saveRelated('transferDtls', $data, $success, 'details', MTransfer::SCENARIO_DEFAULT);
                }
                if ($success) {
                    Yii::$app->trigger($e_name . '_updated', new Event([$model]));
                    $transaction->commit();
                } else {
                    $transaction->rollBack();
                    if ($model->hasRelatedErrors('transferDtls')) {
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

    /**
     * 
     * @param string $id
     * @param array $data
     * @param MTransfer $model
     * @return mixed
     * @throws \Exception
     */
    public static function release($id, $data = [], $model = null)
    {
        $model = $model ? : static::findModel($id);

        $e_name = static::prefixEventName();
        $success = true;
        $model->scenario = MTransfer::SCENARIO_DEFAULT;
        $model->load($data, '');
        $model->status = MTransfer::STATUS_ISSUE;
        try {
            $transaction = Yii::$app->db->beginTransaction();
            Yii::$app->trigger($e_name . '_release', new Event([$model]));

            if (!empty($data['details'])) {
                $transferDtls = ArrayHelper::index($model->transferDtls, 'id_product');
                Yii::$app->trigger($e_name . '_release_head', new Event([$model]));
                foreach ($data['details'] as $dataDetail) {
                    $index = $dataDetail['id_product'];
                    $detail = $transferDtls[$index];
                    $detail->scenario = MTransfer::SCENARIO_RELEASE;
                    $detail->load($dataDetail, '');
                    $success = $success && $detail->save();
                    Yii::$app->trigger($e_name . '_release_body', new Event([$model, $detail]));
                    $transferDtls[$index] = $detail;
                }
                $model->populateRelation('transferDtls', array_values($transferDtls));
                if ($success) {
                    Yii::$app->trigger($e_name . '_release_end', new Event([$model]));
                }
            }
            if ($success && $model->save()) {
                Yii::$app->trigger($e_name . '_released', new Event([$model]));
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
     * @param string $id
     * @param array $data
     * @param MTransfer $model
     * @return mixed
     * @throws \Exception
     */
    public static function receive($id, $data = [], $model = null)
    {
        $model = $model ? : static::findModel($id);

        $e_name = static::prefixEventName();
        $success = true;
        $model->scenario = MTransfer::SCENARIO_DEFAULT;
        $model->load($data, '');
        $model->status = MTransfer::STATUS_ISSUE;
        try {
            $transaction = Yii::$app->db->beginTransaction();
            Yii::$app->trigger($e_name . '_receive', new Event([$model]));

            if (!empty($data['details'])) {
                $transferDtls = ArrayHelper::index($model->transferDtls, 'id_product');
                Yii::$app->trigger($e_name . '_receive_head', new Event([$model]));
                foreach ($data['details'] as $dataDetail) {
                    $index = $dataDetail['id_product'];
                    if (isset($transferDtls[$index])) {
                        $detail = $transferDtls[$index];
                    } else {
                        $detail = new TransferDtl([
                            'id_transfer' => $model->id_transfer,
                            'id_product' => $index,
                            'id_uom' => $dataDetail['id_uom_receive']
                        ]);
                    }
                    $detail->scenario = MTransfer::SCENARIO_RECEIVE;
                    $detail->load($dataDetail, '');
                    $success = $success && $detail->save();
                    Yii::$app->trigger($e_name . '_receive_body', new Event([$model, $detail]));
                    $transferDtls[$index] = $detail;
                }
                $model->populateRelation('transferDtls', array_values($transferDtls));
                if ($success) {
                    Yii::$app->trigger($e_name . '_receive_end', new Event([$model]));
                }
            }
            if ($success && $model->save()) {
                Yii::$app->trigger($e_name . '_received', new Event([$model]));
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
     * @param string $id
     * @param array $data
     * @param MTransfer $model
     * @return mixed
     * @throws \Exception
     */
    public static function complete($id, $data = [], $model = null)
    {
        $model = $model ? : static::findModel($id);

        $e_name = static::prefixEventName();
        $success = true;
        $model->scenario = MTransfer::SCENARIO_DEFAULT;
        $model->load($data, '');
        $model->status = MTransfer::STATUS_RECEIVE;
        try {
            $transaction = Yii::$app->db->beginTransaction();
            Yii::$app->trigger($e_name . '_complete', new Event([$model]));
            $transferDtls = ArrayHelper::index($model->transferDtls, 'id_product');
            if (!empty($data['details'])) {
                Yii::$app->trigger($e_name . '_complete_head', new Event([$model]));
                foreach ($data['details'] as $dataDetail) {
                    $index = $dataDetail['id_product'];
                    $detail = $transferDtls[$index];
                    $detail->scenario = MTransfer::SCENARIO_COMPLETE;
                    $detail->load($dataDetail, '');
                    $success = $success && $detail->save();
                    Yii::$app->trigger($e_name . '_complete_body', new Event([$model, $detail]));
                    $transferDtls[$index] = $detail;
                }
                $model->populateRelation('transferDtls', array_values($transferDtls));
                Yii::$app->trigger($e_name . '_complete_end', new Event([$model]));
            }
            $complete = true;
            foreach ($transferDtls as $detail) {
                $complete = $complete && $detail->transfer_qty_send == $detail->transfer_qty_receive;
            }
            if (!$complete) {
                $model->addError('details', 'Not balance');
            }
            if ($success && $complete && $model->save()) {
                Yii::$app->trigger($e_name . '_completed', new Event([$model]));
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