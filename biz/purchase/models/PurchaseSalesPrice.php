<?php

namespace biz\purchase\models;

use Yii;

/**
 * This is the model class for table "purchase_sales_price".
 *
 * @property integer $id_purchase_dtl
 * @property integer $id_price_category
 * @property double $price
 *
 * @property PurchaseDtl $idPurchaseDtl
 * @property PriceCategory $idPriceCategory
 */
class PurchaseSalesPrice extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%purchase_sales_price}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_purchase_dtl', 'id_price_category'], 'required'],
            [['id_purchase_dtl', 'id_price_category'], 'integer'],
            [['price'], 'number']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_purchase_dtl' => 'Id Purchase Dtl',
            'id_price_category' => 'Id Price Category',
            'price' => 'Price',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdPurchaseDtl()
    {
        return $this->hasOne(PurchaseDtl::className(), ['id_purchase_dtl' => 'id_purchase_dtl']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdPriceCategory()
    {
        return $this->hasOne(PriceCategory::className(), ['id_price_category' => 'id_price_category']);
    }
}
