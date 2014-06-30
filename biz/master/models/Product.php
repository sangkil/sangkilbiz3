<?php

namespace biz\master\models;

use Yii;

/**
 * This is the model class for table "product".
 *
 * @property integer $id_product
 * @property string $cd_product
 * @property string $nm_product
 * @property integer $id_category
 * @property integer $id_group
 * @property string $create_date
 * @property integer $create_by
 * @property string $update_date
 * @property integer $update_by
 *
 * @property ProductStock[] $productStocks
 * @property ProductGroup $idGroup
 * @property Category $idCategory
 * @property Price[] $price
 * @property ProductUom[] $productUoms
 * @property Cogs $cogs
 * @property ProductChild[] $productChildren
 */
class Product extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%product}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cd_product', 'nm_product', 'id_category', 'id_group'], 'required'],
            [['id_category', 'id_group'], 'integer'],
            [['cd_product'], 'string', 'max' => 13],
            [['nm_product'], 'string', 'max' => 64],
            [['cd_product'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_product' => 'Id Product',
            'cd_product' => 'Cd Product',
            'nm_product' => 'Nm Product',
            'id_category' => 'Id Category',
            'id_group' => 'Id Group',
            'create_date' => 'Create Date',
            'create_by' => 'Create By',
            'update_date' => 'Update Date',
            'update_by' => 'Update By',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductStocks()
    {
        return $this->hasMany(ProductStock::className(), ['id_product' => 'id_product']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPrice()
    {
        return $this->hasMany(Price::className(), ['id_product' => 'id_product']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductUoms()
    {
        return $this->hasMany(ProductUom::className(), ['id_product' => 'id_product']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCogs()
    {
        return $this->hasOne(Cogs::className(), ['id_product' => 'id_product']);
    }
    
    public function getCogsValue()
    {
        return $this->cogs->cogs;
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