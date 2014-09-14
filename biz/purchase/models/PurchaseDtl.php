<?php

namespace biz\purchase\models;

use Yii;
use biz\master\models\Product;
use biz\master\models\Uom;
use biz\master\components\Helper as MasterHelper;
use biz\master\models\ProductUom;

/**
 * This is the model class for table "purchase_dtl".
 *
 * @property integer $id_purchase_dtl
 * @property integer $id_purchase
 * @property integer $id_product
 * @property integer $id_warehouse
 * @property integer $id_uom
 * @property double $purch_qty
 * @property double $purch_price
 * @property double $purch_qty_receive
 *
 * @property Purchase $idPurchase
 * @property double[] $salesPrices Description
 */
class PurchaseDtl extends \yii\db\ActiveRecord
{
    public $id_warehouse;
    public $qty_receive;
    public $id_uom_receive;

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
            [['id_purchase', 'id_product', 'id_uom', 'purch_qty', 'purch_price'], 'required'],
            [['id_purchase', 'id_product', 'id_uom'], 'integer'],
            [['purch_qty', 'purch_price'], 'double'],
            [['id_uom', 'id_uom_receive'], 'exist', 'targetClass' => ProductUom::className(),
                'targetAttribute' => 'id_uom', 'filter' => ['id_product' => $this->id_product]],
            [['id_warehouse', 'qty_receive', 'id_uom_receive'], 'safe', 'on' => Purchase::SCENARIO_RECEIVE],
            [['id_warehouse'], 'required', 'on' => Purchase::SCENARIO_RECEIVE, 'when' => function($model) {
                return $model->qty_receive !== null && $model->qty_receive !== '';
            }],
            [['qty_receive'], 'double', 'on' => Purchase::SCENARIO_RECEIVE],
            [['qty_receive'], 'convertReceive', 'on' => Purchase::SCENARIO_RECEIVE],
        ];
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();

        foreach ($scenarios[Purchase::SCENARIO_RECEIVE] as $i => $attr) {
            if (!in_array($attr, ['id_warehouse', 'qty_receive', 'id_uom_receive']) && $attr[0] != '!') {
                $scenarios[Purchase::SCENARIO_RECEIVE][$i] = '!' . $attr;
            }
        }
        return $scenarios;
    }

    public function convertReceive($attribute)
    {
        if ($this->id_uom_receive === null || $this->id_uom == $this->id_uom_receive) {
            $this->purch_qty_receive += $this->qty_receive;
        } else {
            $uoms = ProductUom::find()->where(['id_product' => $this->id_product])->indexBy('id_uom')->all();
            $this->purch_qty_receive += $this->qty_receive * $uoms[$this->id_uom_receive]->isi / $uoms[$this->id_uom]->isi;
        }
        if ($this->purch_qty_receive > $this->purch_qty) {
            $this->addError($attribute, 'Total qty receive large than purch qty');
        }
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
            'sales_price' => 'Selling Price',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdPurchase()
    {
        return $this->hasOne(Purchase::className(), ['id_purchase' => 'id_purchase']);
    }
    /**
     *
     * @var array
     */
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

    public function getIdProduct()
    {
        return $this->hasOne(Product::className(), ['id_product' => 'id_product']);
    }

    public function getIdUom()
    {
        return $this->hasOne(Uom::className(), ['id_uom' => 'id_uom']);
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
                if (!$salesPrice->save()) {
                    throw new \Exception(implode("\n", $salesPrice->firstErrors));
                }
            }
        }
        parent::afterSave($insert, $changedAttributes);
    }
}