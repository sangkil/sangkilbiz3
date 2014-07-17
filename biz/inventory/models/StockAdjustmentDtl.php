<?php

namespace biz\inventory\models;

use Yii;

/**
 * This is the model class for table "stock_adjustment_dtl".
 *
 * @property integer $id_adjustment
 * @property integer $id_product
 * @property integer $id_uom
 * @property double $qty
 * @property double $item_value
 *
 * @property StockAdjustment $idAdjustment
 */
class StockAdjustmentDtl extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%stock_adjustment_dtl}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_adjustment', 'id_product', 'id_uom', 'qty', 'item_value'], 'required'],
            [['id_adjustment', 'id_product', 'id_uom'], 'integer'],
            [['qty', 'item_value'], 'number']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_adjustment' => 'Id Adjustment',
            'id_product' => 'Id Product',
            'id_uom' => 'Id Uom',
            'qty' => 'Qty',
            'item_value' => 'Item Value',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdAdjustment()
    {
        return $this->hasOne(StockAdjustment::className(), ['id_adjustment' => 'id_adjustment']);
    }
}
