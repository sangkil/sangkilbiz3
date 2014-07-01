<?php

namespace biz\master\models;

use Yii;

/**
 * This is the model class for table "global_config".
 *
 * @property string $group
 * @property string $name
 * @property string $value
 * @property string $description
 * @property string $create_at
 * @property integer $create_by
 * @property string $update_at
 * @property integer $update_by
 */
class GlobalConfig extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%global_config}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['group', 'name', 'value'], 'required'],
            [['value'], 'string'],
            [['group'], 'string', 'max' => 16],
            [['name'], 'string', 'max' => 32],
            [['description'], 'string', 'max' => 128]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'group' => 'Config Group',
            'name' => 'Config Name',
            'value' => 'Config Value',
            'description' => 'Description',
            'create_at' => 'Create At',
            'create_by' => 'Create By',
            'update_at' => 'Update At',
            'update_by' => 'Update By',
        ];
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