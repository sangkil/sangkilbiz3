<?php

namespace biz\accounting\models;

use Yii;

/**
 * This is the model class for table "acc_periode".
 *
 * @property integer $id_periode
 * @property string $nm_periode
 * @property string $date_from
 * @property string $date_to
 * @property integer $status
 * @property string $create_at
 * @property integer $create_by
 * @property string $update_at
 * @property integer $update_by
 * @property string $nmStatus
 *
 * @property GlHeader[] $glHeaders
 */
class AccPeriode extends \yii\db\ActiveRecord
{
    const STATUS_OPEN = 1;
    const STATUS_CLOSE = 2;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%acc_periode}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status'], 'unique', 'filter'=>['status'=>  self::STATUS_OPEN]],
            [['nm_periode', 'dateFrom', 'dateTo'], 'required'],
            [['date_from', 'date_to'], 'safe'],
            [['status'], 'integer'],
            [['nm_periode'], 'string', 'max' => 32]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_periode' => 'Id Periode',
            'nm_periode' => 'Nm Periode',
            'date_from' => 'Date From',
            'date_to' => 'Date To',
            'status' => 'Status',
            'create_at' => 'Create At',
            'create_by' => 'Create By',
            'update_at' => 'Update At',
            'update_by' => 'Update By',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGlHeaders()
    {
        return $this->hasMany(GlHeader::className(), ['id_periode' => 'id_periode']);
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
                'class' => 'mdm\converter\DateConverter',
                'attributes' => [
                    'dateFrom' => 'date_from',
                    'dateTo' => 'date_to',
                ]
            ],
            'BizStatusConverter'
        ];
    }
}
