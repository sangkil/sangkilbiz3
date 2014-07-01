<?php

namespace biz\sales\models;

use Yii;
use biz\master\models\Customer;
use biz\master\models\Branch;

/**
 * This is the model class for table "sales".
 *
 * @property integer $id_sales
 * @property string $sales_num
 * @property integer $id_branch
 * @property integer $id_customer
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
 * @property Customer $idCustomer
 * @property Branch $idBranch
 * @property Cashdrawer $idCashdrawer
 * @property SalesDtl[] $salesDtls
 */
class Sales extends \yii\db\ActiveRecord
{
    const STATUS_DRAFT = 1;
    const STATUS_RELEASE = 2;
    const STATUS_CLOSE = 10;

    public $id_warehouse;

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
            [['id_branch', 'id_customer', 'salesDate', 'status'], 'required'],
            [['id_branch', 'id_cashdrawer', 'status', 'id_warehouse'], 'integer'],
            [['discount'], 'number'],
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
    public function getIdCustomer()
    {
        return $this->hasOne(Customer::className(), ['id_customer' => 'id_customer']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdBranch()
    {
        return $this->hasOne(Branch::className(), ['id_branch' => 'id_branch']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdCashdrawer()
    {
        return $this->hasOne(Cashdrawer::className(), ['id_cashdrawer' => 'id_cashdrawer']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSalesDtls()
    {
        return $this->hasMany(SalesDtl::className(), ['id_sales' => 'id_sales'])->with('idCogs');
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
                'group' => 'sales',
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
            'mdm\relation\RelationBehavior'
        ];
    }
}