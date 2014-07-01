<?php

namespace biz\master\models;

use Yii;

/**
 * This is the model class for table "orgn".
 *
 * @property integer $id_orgn
 * @property string $cd_orgn
 * @property string $nm_orgn
 * @property string $create_at
 * @property integer $create_by
 * @property string $update_at
 * @property integer $update_by
 *
 * @property Branch[] $branches
 */
class Orgn extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%orgn}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cd_orgn', 'nm_orgn'], 'required'],
            [['cd_orgn'], 'string', 'max' => 4],
            [['nm_orgn'], 'string', 'max' => 64]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_orgn' => 'Id Orgn',
            'cd_orgn' => 'Cd Orgn',
            'nm_orgn' => 'Nm Orgn',
            'create_at' => 'Create At',
            'create_by' => 'Create By',
            'update_at' => 'Update At',
            'update_by' => 'Update By',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBranches()
    {
        return $this->hasMany(Branch::className(), ['id_orgn' => 'id_orgn']);
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