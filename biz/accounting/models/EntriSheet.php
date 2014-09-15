<?php

namespace biz\accounting\models;

use Yii;

/**
 * This is the model class for table "entri_sheet".
 *
 * @property string $cd_esheet
 * @property string $nm_esheet
 * @property string $create_at
 * @property integer $create_by
 * @property string $update_at
 * @property integer $update_by
 *
 * @property EntriSheetDtl[] $entriSheetDtls
 */
class EntriSheet extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'entri_sheet';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cd_esheet', 'nm_esheet'], 'required'],
            [['cd_esheet'], 'string', 'max' => 16],
            [['nm_esheet'], 'string', 'max' => 64]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'cd_esheet' => 'Cd Esheet',
            'nm_esheet' => 'Nm Esheet',
            'create_at' => 'Create At',
            'create_by' => 'Create By',
            'update_at' => 'Update At',
            'update_by' => 'Update By',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEntriSheetDtls()
    {
        return $this->hasMany(EntriSheetDtl::className(), ['cd_esheet' => 'cd_esheet']);
    }
    
    public function behaviors()
    {
        return [
            'BizTimestampBehavior',
            'BizBlameableBehavior',
            'mdm\behaviors\ar\RelatedBehavior'
        ];
    }
}
