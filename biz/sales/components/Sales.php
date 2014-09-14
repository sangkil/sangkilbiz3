<?php

namespace biz\sales\components;

use biz\sales\models\Sales as MSales;
use biz\app\base\Event;

/**
 * Description of Sales
 *
 * @author Misbahul D Munir (mdmunir) <misbahuldmunir@gmail.com>
 */
class Sales extends \biz\app\base\ApiHelper
{

    public static function modelClass()
    {
        return MSales::className();
    }

    public static function prefixEventName()
    {
        return 'e_sales';
    }

    public static function create($data, $model = null)
    {
        $model = $model ? : new MSales([
            'status' => MSales::STATUS_DRAFT,
            'id_branch' => Yii::$app->user->branch,
            'sales_date' => date('Y-m-d')
        ]);
        $e_name = static::prefixEventName();
        $success = false;
        $model->scenario = MSales::SCENARIO_DEFAULT;
        $model->load($data, '');
        Yii::$app->trigger($e_name . '_create', new Event([$model]));
        if (!empty($post['details'])) {
            try {
                $transaction = Yii::$app->db->beginTransaction();
                $success = $model->save();
                $success = $model->saveRelated('salesDtls', $data, $success, 'details', MSales::SCENARIO_DEFAULT);
                if ($success) {
                    $transaction->commit();
                } else {
                    $transaction->rollBack();
                    if ($model->hasRelatedErrors('salesDtls')) {
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
        $model->scenario = MSales::SCENARIO_DEFAULT;
        $model->load($data, '');
        Yii::$app->trigger($e_name . '_update', new Event([$model]));

        if (!isset($data['details']) || $data['details'] !== []) {
            try {
                $transaction = Yii::$app->db->beginTransaction();
                $success = $model->save();
                if (!empty($data['details'])) {
                    $success = $model->saveRelated('salesDtls', $data, $success, 'details', MSales::SCENARIO_DEFAULT);
                }
                if ($success) {
                    $transaction->commit();
                } else {
                    $transaction->rollBack();
                    if ($model->hasRelatedErrors('salesDtls')) {
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
     * @param MSales $model
     * @return mixed
     * @throws \Exception
     */
    public static function release($id, $data = [], $model = null)
    {
        $model = $model ? : static::findModel($id);

        $e_name = static::prefixEventName();
        $success = true;
        $model->scenario = MSales::SCENARIO_DEFAULT;
        $model->load($data, '');
        $model->status = MSales::STATUS_RELEASE;
        try {
            $transaction = Yii::$app->db->beginTransaction();
            Yii::$app->trigger($e_name . '_release', new Event([$model]));
            $salesDtls = $model->salesDtls;
            if (!empty($data['details'])) {
                Yii::$app->trigger($e_name . '_release_head', new Event([$model]));
                foreach ($data['details'] as $index => $dataDetail) {
                    $detail = $salesDtls[$index];
                    $detail->scenario = MSales::SCENARIO_RELEASE;
                    $detail->load($dataDetail, '');
                    $success = $success && $detail->save();
                    Yii::$app->trigger($e_name . '_release_body', new Event([$model, $detail]));
                    $salesDtls[$index] = $detail;
                }
                $model->populateRelation('salesDtls', $salesDtls);
                Yii::$app->trigger($e_name . '_release_end', new Event([$model]));
            }
            $allReleased = true;
            foreach ($salesDtls as $detail) {
                $allReleased = $allReleased && $detail->sales_qty == $detail->sales_qty_release;
            }
            if($allReleased){
                $model->status = MSales::STATUS_RELEASED;
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
    
}