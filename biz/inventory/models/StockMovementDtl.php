<?php

namespace biz\inventory\models;

use Yii;

/**
 * This is the model class for table "stock_movement_dtl".
 *
 * @property integer $id_movement
 * @property integer $id_warehouse
 * @property integer $id_product
 * @property double $movement_qty
 * @property double $item_value
 *
 * @property StockMovement $idMovement
 */
class StockMovementDtl extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%stock_movement_dtl}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_movement', 'id_warehouse', 'id_product'], 'required'],
            [['id_movement', 'id_warehouse', 'id_product'], 'integer'],
            [['movement_qty', 'item_value'], 'number']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_movement' => 'Id Movement',
            'id_warehouse' => 'Id Warehouse',
            'id_product' => 'Id Product',
            'movement_qty' => 'Movement Qty',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdMovement()
    {
        return $this->hasOne(StockMovement::className(), ['id_movement' => 'id_movement']);
    }
}