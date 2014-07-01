<?php

namespace biz\purchase\models;

use Yii;
use biz\master\models\Product;
use biz\master\models\Uom;
use biz\master\models\Warehouse;

/**
 * This is the model class for table "purchase_dtl".
 *
 * @property integer $id_purchase_dtl
 * @property integer $id_purchase
 * @property integer $id_product
 * @property integer $id_warehouse
 * @property integer $id_uom
 * @property string $purch_qty
 * @property string $purch_price
 * @property string $selling_price
 *
 * @property Uom $idUom
 * @property Purchase $idPurchase
 * @property Product $idProduct
 * @property Warehouse $idWarehouse
 * @property double[] $salesPrices Description
 */
class PurchaseDtl extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%purchase_dtl}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_purchase', 'id_product', 'id_warehouse', 'id_uom', 'purch_qty', 'selling_price'], 'required'],
            [['id_purchase', 'id_product', 'id_warehouse', 'id_uom'], 'integer'],
            [['purch_qty', 'purch_price', 'selling_price'], 'string'],
            [['salesPrices'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_purchase_dtl' => 'Id Purchase Dtl',
            'id_purchase' => 'Id Purchase',
            'id_product' => 'Id Product',
            'id_warehouse' => 'Id Warehouse',
            'id_uom' => 'Id Uom',
            'purch_qty' => 'Purch Qty',
            'purch_price' => 'Purch Price',
            'selling_price' => 'Selling Price',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdUom()
    {
        return $this->hasOne(Uom::className(), ['id_uom' => 'id_uom']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdPurchase()
    {
        return $this->hasOne(Purchase::className(), ['id_purchase' => 'id_purchase']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdProduct()
    {
        return $this->hasOne(Product::className(), ['id_product' => 'id_product']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdWarehouse()
    {
        return $this->hasOne(Warehouse::className(), ['id_warehouse' => 'id_warehouse']);
    }
    private $_salesPrices;

    /**
     * @return array
     */
    public function getSalesPrices()
    {
        if ($this->_salesPrices === null) {
            $prices = PurchaseSalesPrice::findAll(['id_purchase_dtl' => $this->id_purchase_dtl]);
            $this->_salesPrices = \yii\helpers\ArrayHelper::map($prices, 'id_price_category', 'price');
        }
        return $this->_salesPrices;
    }

    public function setSalesPrices($prices)
    {
        $this->_salesPrices = $prices;
    }

    public function afterSave($insert, $changedAttributes)
    {
        if ($this->_salesPrices !== null) {
            PurchaseSalesPrice::deleteAll(['id_purchase_dtl' => $this->id_purchase_dtl]);
            foreach ($this->_salesPrices as $id => $price) {
                if ($price === null || $price === '') {
                    continue;
                }
                $salesPrice = new PurchaseSalesPrice([
                    'id_purchase_dtl' => $this->id_purchase_dtl,
                    'id_price_category' => $id,
                    'price' => $price,
                ]);
                if(!$salesPrice->save()){
                    throw new \Exception(implode("\n", $salesPrice->firstErrors));
                }
            }
        }
        parent::afterSave($insert, $changedAttributes);
    }
}