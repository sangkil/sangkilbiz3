<?php

namespace biz\master\models;

use Yii;

/**
 * This is the model class for table "product_child".
 *
 * @property string $barcode
 * @property integer $id_product
 * @property string $create_at
 * @property string $update_at
 * @property integer $create_by
 * @property integer $update_by
 *
 * @property Product $idProduct
 */
class ProductChild extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%product_child}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['barcode', 'id_product'], 'required'],
            [['id_product'], 'integer'],
            [['barcode'], 'string', 'max' => 13],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'barcode' => 'Barcode',
            'id_product' => 'Id Product',
            'create_at' => 'Create At',
            'update_at' => 'Update At',
            'create_by' => 'Create By',
            'update_by' => 'Update By',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdProduct()
    {
        return $this->hasOne(Product::className(), ['id_product' => 'id_product']);
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
