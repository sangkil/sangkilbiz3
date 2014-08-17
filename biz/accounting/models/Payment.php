<?php

namespace biz\accounting\models;

use Yii;

/**
 * This is the model class for table "payment".
 *
 * @property integer $id_payment
 * @property string $payment_num
 * @property integer $payment_type
 * @property string $payment_date
 * @property string $create_at
 * @property integer $create_by
 * @property string $update_at
 * @property integer $update_by
 *
 * @property PaymentDtl $paymentDtl
 * @property Invoice[] $idInvoices
 */
class Payment extends \yii\db\ActiveRecord
{
    public $totalPaid;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%payment}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['payment_type', 'paymentDate'], 'required'],
            [['payment_type'], 'integer'],
            [['payment_date'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_payment' => 'Id Payment',
            'payment_num' => 'Payment Num',
            'payment_type' => 'Payment Type',
            'payment_date' => 'Payment Date',
            'create_at' => 'Create At',
            'create_by' => 'Create By',
            'update_at' => 'Update At',
            'update_by' => 'Update By',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPaymentDtl()
    {
        return $this->hasMany(PaymentDtl::className(), ['id_payment' => 'id_payment']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdInvoices()
    {
        return $this->hasMany(Invoice::className(), ['id_invoice' => 'id_invoice'])->viaTable('payment_dtl', ['id_payment' => 'id_payment']);
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'BizTimestampBehavior',
            'BizBlameableBehavior',
            [
                'class' => 'mdm\autonumber\Behavior',
                'digit' => 4,
                'attribute' => 'payment_num',
                'value' => 'PY-'.date('ymd').'.?'
            ],
            [
                'class'=>'mdm\converter\DateConverter',
                'attributes'=>[
                    'paymentDate' => 'payment_date',
                ]
            ],
            'mdm\behaviors\ar\RelationBehavior'
        ];
    }
}
