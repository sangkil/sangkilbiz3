<?php

namespace biz\master\models;

use Yii;

/**
 * This is the model class for table "category".
 *
 * @property integer $id_category
 * @property string $cd_category
 * @property string $nm_category
 * @property string $create_at
 * @property integer $create_by
 * @property string $update_at
 * @property integer $update_by
 *
 * @property Product[] $products
 */
class Category extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%category}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cd_category', 'nm_category'], 'required'],
            [['cd_category'], 'string', 'max' => 4],
            [['nm_category'], 'string', 'max' => 32],
            [['cd_category'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_category' => 'Id Category',
            'cd_category' => 'Cd Category',
            'nm_category' => 'Nm Category',
            'create_at' => 'Create At',
            'create_by' => 'Create By',
            'update_at' => 'Update At',
            'update_by' => 'Update By',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Product::className(), ['id_category' => 'id_category']);
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