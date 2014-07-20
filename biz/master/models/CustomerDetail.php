<?php

namespace biz\master\models;

use Yii;

/**
 * This is the model class for table "customer_detail".
 *
 * @property integer $id_customer
 * @property integer $id_distric
 * @property string $addr1
 * @property string $addr2
 * @property string $latitude
 * @property string $longtitude
 * @property integer $id_kab
 * @property integer $id_kec
 * @property integer $id_kel
 * @property string $create_at
 * @property integer $create_by
 * @property string $update_at
 * @property integer $update_by
 *
 * @property Customer $idCustomer
 */
class CustomerDetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%customer_detail}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_customer', 'id_distric', 'addr1'], 'required'],
            [['id_customer', 'id_distric', 'id_kab', 'id_kec', 'id_kel'], 'integer'],
            [['latitude', 'longtitude'], 'string'],
            [['addr1', 'addr2'], 'string', 'max' => 128]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_customer' => 'Id Customer',
            'id_distric' => 'Id Distric',
            'addr1' => 'Addr1',
            'addr2' => 'Addr2',
            'latitude' => 'Latitude',
            'longtitude' => 'Longtitude',
            'id_kab' => 'Id Kab',
            'id_kec' => 'Id Kec',
            'id_kel' => 'Id Kel',
            'create_at' => 'Create At',
            'create_by' => 'Create By',
            'update_at' => 'Update At',
            'update_by' => 'Update By',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdCustomer()
    {
        return $this->hasOne(Customer::className(), ['id_customer' => 'id_customer']);
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'BizTimestampBehavior',
            'BizBlameableBehavior',
        ];
    }
}
