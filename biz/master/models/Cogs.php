<?php

namespace biz\master\models;

use Yii;

/**
 * This is the model class for table "cogs".
 *
 * @property integer $id_product
 * @property integer $id_uom
 * @property string $cogs
 * @property string $create_at
 * @property integer $create_by
 * @property string $update_at
 * @property integer $update_by
 *
 * @property Uom $idUom
 * @property Product $idProduct
 */
class Cogs extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%cogs}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_product', 'id_uom', 'cogs'], 'required'],
            [['id_product', 'id_uom'], 'integer'],
            [['cogs'], 'number']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_product' => 'Id Product',
            'id_uom' => 'Id Uom',
            'cogs' => 'Cogs',
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

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'BizTimestampBehavior',
            'BizBlameableBehavior',
            [
                'class'=>'mdm\logger\RecordLogger',
                'name'=>'log_cogs',
                'attributes'=>['log_by','log_time1','log_time2','id_product','id_uom','cogs','app','id_ref']
            ]
        ];
    }
}