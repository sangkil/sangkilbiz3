<?php

namespace biz\accounting\models;

use Yii;

/**
 * This is the model class for table "invoice".
 *
 * @property integer $id_invoice
 * @property string $invoice_num
 * @property integer $invoice_type
 * @property string $invoice_date
 * @property string $due_date
 * @property integer $id_vendor
 * @property string $invoice_value
 * @property integer $status
 * @property string $create_at
 * @property integer $create_by
 * @property string $update_at
 * @property integer $update_by
 *
 * @property PaymentDtl[] $paymentDtl
 * @property Payment[] $idPayments
 * @property InvoiceDtl $invoiceDtl
 * @property double $paid Description
 * @property double $sisaBayar Description
 */
class Invoice extends \yii\db\ActiveRecord
{
    const TYPE_PURCHASE = 100;
    const TYPE_SALES = 200;
    const STATUS_DRAFT = 1;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%invoice}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status'], 'default', 'value' => self::STATUS_DRAFT],
            [['invoice_type', 'inv_date', 'due_date', 'id_vendor', 'invoice_value'], 'required'],
            [['invoice_type', 'id_vendor', 'status'], 'integer'],
            [['invDate', 'dueDate'], 'safe'],
            [['invoice_value'], 'number']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_invoice' => 'Id Invoice',
            'invoice_num' => 'Inv Num',
            'invoice_type' => 'Type',
            'invoice_date' => 'Inv Date',
            'due_date' => 'Due Date',
            'id_vendor' => 'Id Vendor',
            'invoice_value' => 'Inv Value',
            'status' => 'Status',
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
        return $this->hasMany(PaymentDtl::className(), ['id_invoice' => 'id_invoice']);
    }
    private $_paid;

    public function getPaid()
    {
        if ($this->_paid === null) {
            $this->_paid = 0;
            foreach ($this->paymentDtl as $dtl) {
                $this->_paid+= $dtl->payment_value;
            }
        }

        return $this->_paid;
    }

    public function getSisaBayar()
    {
        return $this->invoice_value - $this->paid;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdPayments()
    {
        return $this->hasMany(Payment::className(), ['id_payment' => 'id_payment'])->viaTable('payment_dtl', ['id_invoice' => 'id_invoice']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInvoiceDtl()
    {
        return $this->hasOne(InvoiceDtl::className(), ['id_invoice' => 'id_invoice']);
    }

    public static function getTypes()
    {
        $class = new \ReflectionClass(self::className());
        $result = [];
        foreach ($class->getConstants() as $key => $value) {
            if (strpos($key, 'TYPE_') === 0) {
                $result[substr($key, 5)] = $value;
            }
        }

        return $result;
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
                'attribute' => 'invoice_num',
                'value' => date('ymd.?')
            ],
            [
                'class' => 'mdm\converter\DateConverter',
                'attributes' => [
                    'invDate' => 'invoice_date',
                    'dueDate' => 'due_date',
                ]
            ],
            [
                'class' => 'mdm\converter\NumeralConverter',
                'attributes' => [
                    'invValue' => 'invoice_value',
                ]
            ],
        ];
    }
}