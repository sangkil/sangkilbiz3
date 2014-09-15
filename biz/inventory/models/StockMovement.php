<?php

namespace biz\inventory\models;

use Yii;

/**
 * This is the model class for table "stock_movement".
 *
 * @property integer $id_movement
 * @property string $movement_num
 * @property integer $movement_type
 * @property integer $id_reff
 * @property string $create_at
 * @property integer $create_by
 * @property string $update_at
 * @property integer $update_by
 *
 * @property StockMovementDtl[] $stockMovementDtls
 */
class StockMovement extends \yii\db\ActiveRecord
{
    const TYPE_PURCHASE = 100;
    const TYPE_SALES = 200;
    const TYPE_TRANSFER_RELEASE = 300;
    const TYPE_TRANSFER_RECEIVE = 400;
    const TYPE_TRANSFER_COMPLETE = 500;
    const TYPE_ADJUSTMENT = 600;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%stock_movement}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['movement_type', 'id_reff'], 'required'],
            [['movement_type'], 'in', 'range' => [self::TYPE_RECEIVE, self::TYPE_ISSUE]],
            [['movement_type', 'id_reff'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_movement' => 'Id Movement',
            'movement_num' => 'Movement Num',
            'movement_type' => 'Movement Type',
            'id_reff' => 'Id Reff',
            'create_at' => 'Create At',
            'create_by' => 'Create By',
            'update_at' => 'Update At',
            'update_by' => 'Update By',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStockMovementDtls()
    {
        return $this->hasMany(StockMovementDtl::className(), ['id_movement' => 'id_movement']);
    }

    public function behaviors()
    {
        return [
            'BizTimestampBehavior',
            'BizBlameableBehavior',
            [
                'class' => 'mdm\autonumber\Behavior',
                'digit' => 6,
                'attribute' => 'movement_num',
                'value' => 'MV' . date('Ym?'),
            ],
            'mdm\behaviors\ar\RelatedBehavior',
        ];
    }
}