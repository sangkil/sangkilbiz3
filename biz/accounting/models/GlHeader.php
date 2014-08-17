<?php

namespace biz\accounting\models;

use Yii;
use biz\accounting\components\Helper;
use biz\master\models\Branch;
/**
 * This is the model class for table "gl_header".
 *
 * @property integer $id_gl
 * @property string $gl_date
 * @property string $gl_num
 * @property integer $id_branch
 * @property integer $id_periode
 * @property integer $type_reff
 * @property integer $id_reff
 * @property string $description
 * @property integer $status
 * @property string $create_at
 * @property integer $create_by
 * @property string $update_at
 * @property integer $update_by
 * @property string $glDate
 *
 * @property GlDetail[] $glDetails
 * @property AccPeriode $idPeriode
 * @property Branch $idBranch
 * @method boolean|GlDetail[] saveRelation(string $relation) Description
 */
class GlHeader extends \yii\db\ActiveRecord
{
    const TYPE_PURCHASE = 100;
    const TYPE_SALES = 200;
    const STATUS_ACTIVE = 1;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%gl_header}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_periode'], 'default', 'value' => Helper::getCurrentIdAccPeriode()],
            [['status'], 'default', 'value' => self::STATUS_ACTIVE],
            [['glDate', 'id_branch', 'id_periode', 'description', 'status'], 'required'],
            [['description'], 'string'],
            [['gl_date'], 'safe'],
            [['id_branch', 'id_periode', 'type_reff', 'id_reff', 'status'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_gl' => 'Id Gl',
            'gl_date' => 'Gl Date',
            'gl_num' => 'Gl Num',
            'id_branch' => 'Id Branch',
            'id_periode' => 'Id Periode',
            'type_reff' => 'Type Reff',
            'id_reff' => 'Id Reff',
            'description' => 'Description',
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
    public function getGlDetails()
    {
        return $this->hasMany(GlDetail::className(), ['id_gl' => 'id_gl']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdPeriode()
    {
        return $this->hasOne(AccPeriode::className(), ['id_periode' => 'id_periode']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdBranch()
    {
        return $this->hasOne(Branch::className(), ['id_branch' => 'id_branch']);
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
                'class' => 'mdm\autonumber\Behavior',
                'digit' => 4,
                'attribute' => 'gl_num',
                'value' => 'GL' . date('ymd.?')
            ],
            [
                'class' => 'mdm\converter\DateConverter',
                'physicalFormat' => 'Y-m-d',
                'attributes' => [
                    'glDate' => 'gl_date'
                ]
            ],
            'mdm\behaviors\ar\RelationBehavior'
        ];
    }
}
