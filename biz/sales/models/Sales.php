<?php

namespace biz\sales\models;

use Yii;
use biz\master\models\Customer;

/**
 * This is the model class for table "sales".
 *
 * @property integer $id_sales
 * @property string $sales_num
 * @property integer $id_branch
 * @property integer $id_customer
 * @property integer $id_warehouse
 * @property integer $id_cashdrawer
 * @property string $discount
 * @property string $sales_date
 * @property integer $status
 * @property string $create_at
 * @property integer $create_by
 * @property string $update_at
 * @property integer $update_by
 *
 * @property string $nmStatus
 * @property string $salesDate
 *
 * @property SalesDtl[] $salesDtls
 * @property Customer $idCustomer
 * @method boolean|integer saveRelated(string $relation, array $data, array $options)
 */
class Sales extends \yii\db\ActiveRecord
{
    const STATUS_DRAFT = 1;
    const STATUS_RELEASE = 2;
    const STATUS_RELEASED = 3;
    const STATUS_CLOSE = 10;
    
    const SCENARIO_RELEASE = 'release';
    
    private $_nm_customer;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%sales}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nmCustomer'], 'in', 'range' => Customer::find()->select(['nm_customer'])->column()],
            [['id_branch', 'id_customer', 'nmCustomer', 'id_warehouse', 'salesDate', 'status','sales_value'], 'required'],
            [['id_branch', 'id_cashdrawer', 'status', 'id_warehouse'], 'integer'],
            [['discount','sales_value'], 'number'],
            [['sales_date'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_sales' => 'Id Sales',
            'sales_num' => 'Sales Num',
            'id_branch' => 'Id Branch',
            'id_customer' => 'Id Customer',
            'id_cashdrawer' => 'Id Cashdrawer',
            'discount' => 'Discount',
            'sales_date' => 'Sales Date',
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
    public function getSalesDtls()
    {
        return $this->hasMany(SalesDtl::className(), ['id_sales' => 'id_sales'])->with('idCogs');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdCustomer()
    {
        return $this->hasOne(Customer::className(), ['id_customer' => 'id_customer']);
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdBranch()
    {
        return $this->hasOne(\biz\master\models\Branch::className(), ['id_branch' => 'id_branch']);
    }

    public function getNmCustomer()
    {
        if ($this->_nm_customer === null) {
            $this->_nm_customer = $this->idCustomer ? $this->idCustomer->nm_customer : null;
        }

        return $this->_nm_customer;
    }

    public function setNmCustomer($value)
    {
        $this->_nm_customer = $value;
        $cust = Customer::findOne(['nm_customer' => $value]);
        if ($cust) {
            $this->id_customer = $cust->id_customer;
        } else {
            $this->id_customer = null;
        }
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
                'attribute' => 'sales_num',
                'value' => 'SA.' . date('ymd.') . '?'
            ],
            [
                'class' => 'mdm\converter\DateConverter',
                'attributes' => [
                    'salesDate' => 'sales_date',
                ]
            ],
            'BizStatusConverter',
            'mdm\behaviors\ar\RelatedBehavior'
        ];
    }
}
