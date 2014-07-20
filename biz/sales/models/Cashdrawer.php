<?php

namespace biz\sales\models;

use Yii;
use common\models\User;

/**
 * This is the model class for table "cashdrawer".
 *
 * @property integer $id_cashdrawer
 * @property string $client_machine
 * @property integer $id_branch
 * @property integer $cashier_no
 * @property integer $id_user
 * @property string $init_cash
 * @property string $close_cash
 * @property string $variants
 * @property integer $status
 * @property string $create_at
 * @property integer $create_by
 * @property string $update_at
 * @property integer $update_by
 *
 * @property Branch $idBranch
 * @property User $idUser
 * @property Sales[] $salesHdrs
 */
class Cashdrawer extends \yii\db\ActiveRecord
{
    const STATUS_OPEN = 1;
    const STATUS_PROCESS = 2;
    const STATUS_CLOSE = 3;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%cashdrawer}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['client_machine'], 'default', 'value' => Yii::$app->clientId],
            [['id_user'], 'default', 'value' => Yii::$app->user->id],
            [['id_user'], 'unique',
                'filter' => ['status' => self::STATUS_OPEN],
                'message' => 'Already opened drawer for this user'],
            [['client_machine'], 'unique',
                'filter' => ['status' => self::STATUS_OPEN],
                'message' => 'Already opened drawer in this client'],
            [['status'], 'default', 'value' => self::STATUS_OPEN],
            [['id_branch', 'cashier_no'], 'required'],
            [['id_branch', 'cashier_no', 'id_user', 'status'], 'integer'],
            [['init_cash', 'close_cash', 'variants'], 'double'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_cashdrawer' => 'Id Cashdrawer',
            'client_machine' => 'Client Machine',
            'id_branch' => 'Id Branch',
            'cashier_no' => 'Cashier No',
            'id_user' => 'Id User',
            'init_cash' => 'Init Cash',
            'close_cash' => 'Close Cash',
            'variants' => 'Variants',
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
    public function getIdBranch()
    {
        return $this->hasOne(Branch::className(), ['id_branch' => 'id_branch']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdUser()
    {
        return $this->hasOne(User::className(), ['id' => 'id_user']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSaless()
    {
        return $this->hasMany(Sales::className(), ['id_cashdrawer' => 'id_cashdrawer']);
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
                'physicalFormat' => 'Y-m-d H:i:s.u',
                'logicalFormat' => 'd-m-Y H:i:s',
                'attributes' => [
                    'open_time' => 'create_at'
                ]
            ],
            'BizStatusConverter'
        ];
    }
}
