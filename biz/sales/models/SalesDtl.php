<?php

namespace biz\sales\models;

use Yii;
use biz\master\models\Product;
use biz\master\models\Uom;
use biz\master\models\Cogs;
use biz\master\models\Warehouse;

/**
 * This is the model class for table "sales_dtl".
 *
 * @property integer $id_sales_dtl
 * @property integer $id_sales
 * @property integer $id_product
 * @property integer $id_uom
 * @property integer $id_warehouse
 * @property double $sales_price
 * @property double $sales_qty
 * @property double $sales_qty_release
 * @property double $discount
 * @property double $cogs
 * @property double $tax
 *
 * @property Uom $idUom
 * @property Sales $idSales
 * @property Product $idProduct
 * @property Cogs $idCogs
 * @property Warehouse $idWarehouse
 */
class SalesDtl extends \yii\db\ActiveRecord
{
    public $id_warehouse;
    public $qty_release;
    public $id_uom_release;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%sales_dtl}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cogs'], 'default', 'value' => function($model) {
                return $model->idCogs ? $model->idCogs->cogs : 0;
            }],
            [['id_sales', 'id_product', 'id_uom', 'sales_price', 'sales_qty'], 'required'],
            [['id_sales', 'id_product', 'id_uom',], 'integer'],
            [['sales_price', 'sales_qty', 'discount', 'cogs', 'tax'], 'number'],
            [['id_warehouse', 'qty_release', 'id_uom_release'], 'safe', 'on' => Sales::SCENARIO_RELEASE],
            [['id_warehouse'], 'required', 'on' => Sales::SCENARIO_RELEASE, 'when' => function($model) {
                return $model->qty_release !== null && $model->qty_release !== '';
            }],
            [['qty_receive'], 'double', 'on' => Sales::SCENARIO_RELEASE],
            [['qty_release'],'convertRelease', 'on'=>  Sales::SCENARIO_RELEASE],
        ];
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();

        foreach ($scenarios[Sales::SCENARIO_RELEASE] as $i => $attr) {
            if (!in_array($attr, ['id_warehouse', 'qty_release', 'id_uom_release']) && $attr[0] != '!') {
                $scenarios[Sales::SCENARIO_RELEASE][$i] = '!' . $attr;
            }
        }
        return $scenarios;
    }

    public function convertRelease($attribute)
    {
        if ($this->id_uom_release === null || $this->id_uom == $this->id_uom_release) {
            $this->sales_qty_release += $this->qty_release;
        } else {
            $uoms = ProductUom::find()->where(['id_product' => $this->id_product])->indexBy('id_uom')->all();
            $this->sales_qty_release += $this->qty_release * $uoms[$this->id_uom_release]->isi / $uoms[$this->id_uom]->isi;
        }
        if ($this->sales_qty_release > $this->sales_qty) {
            $this->addError($attribute, 'Total qty release large than purch qty');
        }
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_sales_dtl' => 'Id Sales Dtl',
            'id_sales' => 'Id Sales',
            'id_product' => 'Id Product',
            'id_uom' => 'Id Uom',
            'id_warehouse' => 'Id Warehouse',
            'sales_price' => 'Sales Price',
            'sales_qty' => 'Sales Qty',
            'discount' => 'Discount',
            'cogs' => 'Cogs',
            'tax' => 'Tax',
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
    public function getIdSales()
    {
        return $this->hasOne(Sales::className(), ['id_sales' => 'id_sales']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdCogs()
    {
        return $this->hasOne(Cogs::className(), ['id_product' => 'id_product']);
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
}