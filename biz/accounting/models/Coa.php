<?php

namespace biz\accounting\models;

use Yii;

/**
 * This is the model class for table "coa".
 *
 * @property integer $id_coa
 * @property integer $id_parent
 * @property string $cd_account
 * @property string $nm_account
 * @property integer $coa_type
 * @property string $normal_balance
 * @property string $create_at
 * @property integer $create_by
 * @property string $update_at
 * @property integer $update_by
 * @property string $nmCoaType
 *
 * @property GlDetail[] $glDetails
 * @property EntriSheetDtl[] $entriSheetDtls
 * @property Coa $idCoaParent
 * @property Coa[] $coas
 */
class Coa extends \yii\db\ActiveRecord
{
    const TYPE_AKTIVA = 100000;
    const TYPE_KEWAJIBAN = 200000;
    const TYPE_MODAL = 300000;
    const TYPE_PENDAPATAN = 400000;
    const TYPE_HPP = 500000;
    const TYPE_BIAYA = 600000;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%coa}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cd_account', 'nm_account', 'coa_type', 'normal_balance'], 'required'],
            [['id_parent'], 'safe'],
            [['cd_account'], 'string', 'max' => 16],
            [['cd_account'], 'checkCoaCode'],
            [['nm_account'], 'string', 'max' => 64],
            [['normal_balance'], 'string', 'max' => 1]
        ];
    }

    public function checkCoaCode($attribute)
    {
        $coa = $this->idParent;
        if ($coa && strpos($this->$attribute, rtrim($coa->cd_account, '0')) !== 0) {
            $this->addError($attribute, 'Code Account prefix invalid');
        }
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_coa' => 'Id Coa',
            'id_parent' => 'Id Parent',
            'cd_account' => 'Cd Account',
            'nm_account' => 'Nm Account',
            'coa_type' => 'Coa Type',
            'normal_balance' => 'Normal Balance',
            'create_at' => 'Create At',
            'create_by' => 'Create By',
            'update_at' => 'Update At',
            'update_by' => 'Update By',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGlDetails()
    {
        return $this->hasMany(GlDetail::className(), ['id_coa' => 'id_coa']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEntriSheetDtls()
    {
        return $this->hasMany(EntriSheetDtl::className(), ['id_coa' => 'id_coa']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdParent()
    {
        return $this->hasOne(Coa::className(), ['id_coa' => 'id_parent']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCoas()
    {
        return $this->hasMany(Coa::className(), ['id_parent' => 'id_coa']);
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
                'class' => 'mdm\converter\EnumConverter',
                'enumPrefix' => 'TYPE_',
                'attributes' => [
                    'nmCoaType' => 'coa_type',
                ]
            ],
            [
                'class' => 'mdm\converter\DateConverter',
                'logicalFormat'=>'d-m-Y',
                'physicalFormat'=>'Y-m-d H:i:s',
                'attributes' => [
                    'createDate' => 'create_at',
                ]
            ],
        ];
    }
}