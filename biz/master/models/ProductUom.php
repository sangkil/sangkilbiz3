<?php

namespace biz\master\models;

use Yii;

/**
 * This is the model class for table "product_uom".
 *
 * @property integer $id_puom
 * @property integer $id_product
 * @property string $nmProduct
 * @property integer $id_uom
 * @property integer $isi
 * @property string $create_at
 * @property integer $create_by
 * @property string $update_at
 * @property integer $update_by
 *
 * @property Uom $idUom
 * @property Product $idProduct
 */
class ProductUom extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%product_uom}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nmProduct'], 'in', 'range'=>  Product::find()->select('nm_product')->column()],
            [['id_product', 'id_uom', 'isi'], 'required'],
            [['id_product', 'id_uom', 'isi'], 'integer'],
            [['id_uom'],'unique','targetAttribute' => ['id_product', 'id_uom']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_puom' => 'Id Puom',
            'id_product' => 'Id Product',
            'id_uom' => 'Id Uom',
            'isi' => 'Isi',
            'create_at' => 'Create At',
            'create_by' => 'Create By',
            'update_at' => 'Update At',
            'update_by' => 'Update By',
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
    public function getIdProduct()
    {
        return $this->hasOne(Product::className(), ['id_product' => 'id_product']);
    }

    public function setNmProduct($value)
    {
        if (($product = Product::findOne(['nm_product' => $value])) !== null) {
            $this->id_product = $product->id_product;
        } else {
            $this->id_product = null;
        }
    }

    public function getNmProduct()
    {
        if (($product = $this->idProduct) !== null) {
            return $product->nm_product;
        } else {
            return null;
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
        ];
    }
}