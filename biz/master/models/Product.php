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
 * @property string $create_at
 * @property integer $create_by
 * @property string $update_at
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
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 2;

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
            [['cd_product', 'nm_product', 'id_category', 'id_group','status'], 'required'],
            [['id_category', 'id_group','status'], 'integer'],
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
            'create_at' => 'Create At',
            'create_by' => 'Create By',
            'update_at' => 'Update At',
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
    public function getBarcodes()
    {
        return $this->hasMany(ProductChild::className(), ['id_product' => 'id_product']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCogs()
    {
        return $this->hasOne(Cogs::className(), ['id_product' => 'id_product']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdCategory()
    {
        return $this->hasOne(Category::className(), ['id_category' => 'id_category']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdGroup()
    {
        return $this->hasOne(ProductGroup::className(), ['id_group' => 'id_group']);
    }
    
    public function getCogsValue()
    {
        if($this->cogs){
            return $this->cogs->cogs;
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
            'BizStatusConverter',
        ];
    }
}