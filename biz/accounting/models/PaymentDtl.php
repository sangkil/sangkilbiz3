<?php

namespace biz\accounting\models;

use Yii;

/**
 * This is the model class for table "payment_dtl".
 *
 * @property integer $id_payment
 * @property integer $id_invoice
 * @property double $payment_value
 *
 * @property Payment $idPayment
 * @property Invoice $idInvoice
 * @property string $payVal Description
 */
class PaymentDtl extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%payment_dtl}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_payment', 'id_invoice', 'payVal'], 'required'],
            [['id_payment', 'id_invoice'], 'integer'],
            [['payment_value'],'double']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_payment' => 'Id Payment',
            'id_invoice' => 'Id Invoice',
            'payment_value' => 'Pay Val',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdPayment()
    {
        return $this->hasOne(Payment::className(), ['id_payment' => 'id_payment']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdInvoice()
    {
        return $this->hasOne(Invoice::className(), ['id_invoice' => 'id_invoice']);
    }

    public function behaviors()
    {
        return[
            [
                'class' => 'mdm\converter\NumeralConverter',
                'attributes' => [
                    'payVal' => 'payment_value',
                ]
            ]
        ];
    }
}