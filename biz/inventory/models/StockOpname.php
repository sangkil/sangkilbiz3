<?php

namespace biz\inventory\models;

use Yii;
use biz\master\models\Warehouse;

/**
 * This is the model class for table "stock_opname".
 *
 * @property integer $id_opname
 * @property string $opname_num
 * @property integer $id_warehouse
 * @property string $opname_date
 * @property string $opnameDate
 * @property string $description
 * @property integer $status
 * @property string $nmStatus
 * @property string $operator
 * @property string $create_at
 * @property integer $create_by
 * @property string $update_at
 * @property integer $update_by
 *
 * @property StockOpnameDtl[] $stockOpnameDtls
 * @property Warehouse $idWarehouse
 */
class StockOpname extends \yii\db\ActiveRecord
{
    const STATUS_DRAFT = 1;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%stock_opname}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status'],'default','value'=>  self::STATUS_DRAFT],
            [['id_warehouse', 'opnameDate', 'status'], 'required'],
            [['id_warehouse', 'status'], 'integer'],
            [['opname_date', 'create_at', 'update_at'], 'safe'],
            [['opname_num'], 'string', 'max' => 16],
            [['description', 'operator'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_opname' => 'Id Opname',
            'opname_num' => 'Opname Num',
            'id_warehouse' => 'Id Warehouse',
            'opname_date' => 'Opname Date',
            'description' => 'Description',
            'status' => 'Status',
            'operator' => 'Operator',
            'create_at' => 'Create At',
            'create_by' => 'Create By',
            'update_at' => 'Update At',
            'update_by' => 'Update By',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStockOpnameDtls()
    {
        return $this->hasMany(StockOpnameDtl::className(), ['id_opname' => 'id_opname']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdWarehouse()
    {
        return $this->hasOne(Warehouse::className(), ['id_warehouse' => 'id_warehouse']);
    }

    public function behaviors()
    {
        return [
            'BizTimestampBehavior',
            'BizBlameableBehavior',
            [
                'class' => 'mdm\autonumber\Behavior',
                'digit' => 6,
                'attribute' => 'opname_num',
                'value' => 'OP' . date('y.?')
            ],
            [
                'class'=>'mdm\converter\DateConverter',
                'attributes' => [
                    'opnameDate' => 'opname_date',
                ]
            ],
            'BizStatusConverter',
            'mdm\behaviors\ar\RelationBehavior',
        ];
    }
}
