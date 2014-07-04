<?php

namespace biz\master\models;

use Yii;

/**
 * This is the model class for table "customer".
 *
 * @property integer $id_customer
 * @property string $cd_customer
 * @property string $nm_customer
 * @property string $contact_name
 * @property string $contact_number
 * @property integer $status
 * @property integer $update_by
 * @property integer $create_by
 * @property string $update_at
 * @property string $create_at
 * @property string $nmStatus
 *
 * @property CustomerDetail $customerDetail
 * @property Sales[] $salesHdrs
 */
class Customer extends \yii\db\ActiveRecord
{
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 2;
    const STATUS_BLOCKED = 3;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%customer}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cd_customer', 'nm_customer'], 'required'],
            [['status'], 'integer'],
            [['cd_customer'], 'string', 'max' => 13],
            [['nm_customer', 'contact_name', 'contact_number'], 'string', 'max' => 64],
            [['cd_customer'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_customer' => 'Id Customer',
            'cd_customer' => 'Cd Cust',
            'nm_customer' => 'Nm Cust',
            'contact_name' => 'Contact Name',
            'contact_number' => 'Contact Number',
            'status' => 'Status',
            'update_by' => 'Update By',
            'create_by' => 'Create By',
            'update_at' => 'Update At',
            'create_at' => 'Create At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCustomerDetail()
    {
        return $this->hasOne(CustomerDetail::className(), ['id_customer' => 'id_customer']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSaless()
    {
        return $this->hasMany(Sales::className(), ['id_customer' => 'id_customer']);
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'BizTimestampBehavior',
            'BizBlameableBehavior',
            'BizStatusConverter'
        ];
    }
}