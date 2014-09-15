<?php

namespace biz\accounting\components;

use biz\accounting\models\Invoice as MInvoice;
use yii\db\Query;
use biz\accounting\models\InvoiceDtl;
use yii\helpers\ArrayHelper;

/**
 * Description of Invoice
 *
 * @author Misbahul D Munir (mdmunir) <misbahuldmunir@gmail.com>
 */
class Invoice extends \biz\app\base\ApiHelper
{

    public static function modelClass()
    {
        return MInvoice::className();
    }

    public static function prefixEventName()
    {
        return 'e_invoice';
    }

    public static function create($data, $model = null)
    {
        $model = $model ? : new MInvoice();
        $e_name = static::prefixEventName();
        $success = false;
        $model->scenario = MInvoice::SCENARIO_DEFAULT;
        $model->load($data, '');
        if (!empty($data['details'])) {
            try {
                $transaction = Yii::$app->db->beginTransaction();
                Yii::$app->trigger($e_name . '_create', new Event([$model]));
                $success = $model->save();
                $success = $model->saveRelated('invoiveDtls', $data, $success, 'details');
                if ($success) {
                    Yii::$app->trigger($e_name . '_created', new Event([$model]));
                    $transaction->commit();
                } else {
                    $transaction->rollBack();
                    if ($model->hasRelatedErrors('invoiveDtls')) {
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
        $model->scenario = MInvoice::SCENARIO_DEFAULT;
        $model->load($data, '');
        if (!isset($data['details']) || $data['details'] !== []) {
            try {
                $transaction = Yii::$app->db->beginTransaction();
                Yii::$app->trigger($e_name . '_update', new Event([$model]));
                $success = $model->save();
                if (!empty($data['details'])) {
                    $success = $model->saveRelated('invoiveDtls', $data, $success, 'details');
                }
                if ($success) {
                    Yii::$app->trigger($e_name . '_updated', new Event([$model]));
                    $transaction->commit();
                } else {
                    $transaction->rollBack();
                    if ($model->hasRelatedErrors('invoiveDtls')) {
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
    
    public function createFromPurchase($data, $model=null)
    {
        $inv_vals = ArrayHelper::map($data['details'], 'id_purchase', 'value');
        $ids = array_keys($inv_vals);
        
        $c_inv_vals = (new Query())
            ->select(['p.id_purchase','jml'=>'sum(ivd.trans_value)',
                'p.purchase_value','p.item_discount','p.id_supplier'])
            ->from(['p'=>'{{%purchase}}'])
            ->innerJoin(['ivd'=>'{{%invoice_dtl}}'], '{{p}}.[[id_purchase]]={{ivd}}.[[id_reff]]')
            ->innerJoin(['iv'=>'{{%invoice}}'], '{{iv}}.[[id_invoice]]={{iv}}.[[id_invoice]]')
            ->where(['iv.invoice_type'=> MInvoice::TYPE_PURCHASE,'ivd.id_reff'=>$ids])
            ->groupBy('p.id_purchase')
            ->indexBy('id_purchase')
            ->all();
        
        
        // query data purchase
        
        
        return static::create($data, $model);
    }
}