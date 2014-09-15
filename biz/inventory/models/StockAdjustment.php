<?php

namespace biz\inventory\models;

use Yii;

/**
 * This is the model class for table "stock_adjustment".
 *
 * @property integer $id_adjustment
 * @property string $adjustment_num
 * @property integer $id_warehouse
 * @property string $adjustment_date
 * @property integer $id_reff
 * @property string $description
 * @property integer $status
 * @property string $create_at
 * @property integer $create_by
 * @property string $update_at
 * @property integer $update_by
 *
 * @property StockAdjustmentDtl[] $stockAdjustmentDtls
 */
class StockAdjustment extends \yii\db\ActiveRecord
{
    const STATUS_DRAFT = 1;
    const STATUS_APPLIED = 2;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%stock_adjustment}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status'], 'default', 'value' => self::STATUS_DRAFT],
            [['adjustment_num', 'id_warehouse', 'adjustment_date', 'status'], 'required'],
            [['id_warehouse', 'id_reff', 'status'], 'integer'],
            [['adjustment_date'], 'safe'],
            [['adjustment_num'], 'string', 'max' => 16],
            [['description'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_adjustment' => 'Id Adjustment',
            'adjustment_num' => 'Adjustment Num',
            'id_warehouse' => 'Id Warehouse',
            'adjustment_date' => 'Adjustment Date',
            'id_reff' => 'Id Reff',
            'description' => 'Description',
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
    public function getStockAdjustmentDtls()
    {
        return $this->hasMany(StockAdjustmentDtl::className(), ['id_adjustment' => 'id_adjustment']);
    }

    public function behaviors()
    {
        return [
            'BizTimestampBehavior',
            'BizBlameableBehavior',
            [
                'class' => 'mdm\autonumber\Behavior',
                'digit' => 6,
                'attribute' => 'adjustment_num',
                'value' => 'AJ' . date('y.?')
            ],
            [
                'class' => 'mdm\converter\DateConverter',
                'attributes' => [
                    'adjstmentDate' => 'adjustment_date',
                ]
            ],
            'BizStatusConverter',
            'mdm\behaviors\ar\RelatedBehavior',
        ];
    }
}