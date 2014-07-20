<?php

namespace biz\master\models;

use Yii;

/**
 * This is the model class for table "supplier".
 *
 * @property integer $id_supplier
 * @property string $cd_supplier
 * @property string $nm_supplier
 * @property string $create_at
 * @property integer $create_by
 * @property string $update_at
 * @property integer $update_by
 *
 * @property Purchase[] $purchaseHdrs
 * @property ProductSupplier $productSupplier
 * @property Product[] $idProducts
 */
class Supplier extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%supplier}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cd_supplier', 'nm_supplier'], 'required'],
            [['cd_supplier'], 'string', 'max' => 4],
            [['nm_supplier'], 'string', 'max' => 32],
            [['cd_supplier'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_supplier' => 'Id Supplier',
            'cd_supplier' => 'Cd Supplier',
            'nm_supplier' => 'Nm Supplier',
            'create_at' => 'Create At',
            'create_by' => 'Create By',
            'update_at' => 'Update At',
            'update_by' => 'Update By',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPurchases()
    {
        return $this->hasMany(Purchase::className(), ['id_supplier' => 'id_supplier']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductSupplier()
    {
        return $this->hasOne(ProductSupplier::className(), ['id_supplier' => 'id_supplier']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdProducts()
    {
        return $this->hasMany(Product::className(), ['id_product' => 'id_product'])->viaTable('product_supplier', ['id_supplier' => 'id_supplier']);
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
