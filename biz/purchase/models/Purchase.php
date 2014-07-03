<?php

namespace biz\purchase\models;

use Yii;
use biz\master\models\Supplier;
use biz\master\models\Branch;

/**
 * This is the model class for table "purchase".
 *
 * @property integer $id_purchase
 * @property string $purchase_num
 * @property integer $id_supplier
 * @property integer $id_branch
 * @property string $purchase_date
 * @property string $purchase_value
 * @property string $item_discount
 * @property integer $status
 * @property string $create_at
 * @property integer $create_by
 * @property string $update_at
 * @property integer $update_by
 * 
 * @property string $nmStatus
 * @property string $nmSupplier
 * @property string $nmBranch
 * @property string $purchaseDate
 *
 * @property PurchaseDtl[] $purchaseDtls
 * 
 * @method array saveRelation(string $relation, array $data, array $options) Description
 */
class Purchase extends \yii\db\ActiveRecord
{
    const STATUS_DRAFT = 1;
    const STATUS_RECEIVE = 2;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%purchase}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nmSupplier'],'exist','targetClass'=>  Supplier::className(),'targetAttribute'=>'nm_supplier'],
            [['nmSupplier', 'id_branch', 'id_warehouse', 'purchaseDate', 'purchase_value', 'status'], 'required'],
            [['id_branch', 'status'], 'integer'],
            [['id_supplier', 'purchase_date'], 'safe'],
            [['item_discount'], 'number']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_purchase' => 'Id Purchase',
            'purchase_num' => 'Purchase Num',
            'id_supplier' => 'Id Supplier',
            'id_branch' => 'Id Branch',
            'purchase_date' => 'Purchase Date',
            'purchase_value' => 'Purchase Value',
            'item_discount' => 'Item Discount',
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
    public function getPurchaseDtls()
    {
        return $this->hasMany(PurchaseDtl::className(), ['id_purchase' => 'id_purchase']);
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdSupplier()
    {
        return $this->hasOne(Supplier::className(), ['id_supplier' => 'id_supplier']);
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdBranch()
    {
        return $this->hasOne(Branch::className(), ['id_branch' => 'id_branch']);
    }
    
    public function getNmSupplier()
    {
        $supp = Supplier::findOne(['id_supplier'=>  $this->id_supplier]);
        if($supp){
            return $supp->nm_supplier;
        }  else {
            return null;
        }
    }
    
    public function setNmSupplier($value)
    {
        $supp = Supplier::findOne(['nm_supplier'=>$value]);
        if($supp){
            $this->id_supplier = $supp->id_supplier;
        }  else {
            $this->id_supplier = null;
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
                'group' => 'purchase',
                'attribute' => 'purchase_num',
                'value' => 'PU' . date('y.?')
            ],
            [
                'class' => 'mdm\converter\DateConverter',
                'attributes' => [
                    'purchaseDate' => 'purchase_date',
                ]
            ],
            'BizStatusConverter',
            'mdm\relation\RelationBehavior',
        ];
    }
}