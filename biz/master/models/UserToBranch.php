<?php

namespace biz\master\models;

use Yii;
use \app\models\User;

/**
 * This is the model class for table "user_to_branch".
 *
 * @property integer $id_branch
 * @property integer $id_user
 * @property string $create_at
 * @property integer $create_by
 * @property string $update_at
 * @property integer $update_by
 *
 * @property Branch $idBranch
 */
class UserToBranch extends \yii\db\ActiveRecord {

    public $nm_branch;
    private $_username;

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%user_to_branch}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['nmUser'], 'in', 'range' => User::find()->select(['username'])->column()],
            [['id_branch', 'id_user', 'nmUser'], 'required'],
            [['id_branch', 'id_user'], 'integer'],
            [['id_user'], 'exist', 'targetAttribute' => 'id', 'targetClass' => User::className()]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id_branch' => 'Id Branch',
            'id_user' => 'Id User',
            'create_at' => 'Create At',
            'create_by' => 'Create By',
            'update_at' => 'Update At',
            'update_by' => 'Update By',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdBranch() {
        return $this->hasOne(Branch::className(), ['id_branch' => 'id_branch']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdUser() {
        return $this->hasOne(\app\models\User::className(), ['id' => 'id_user']);
    }

    public function setNmUser($value) {
        $this->_username = $value;
        $user = User::findOne(['username' => $value]);
        if ($user) {
            $this->id_user = $user->id;
        } else {
            $this->id_user = null;
        }
    }

    public function getNmUser() {
        if ($this->_username === null) {
            $this->_username = $this->id_user ? $this->idUser->username : null;
        }

        return $this->_username;
    }

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'BizTimestampBehavior',
            'BizBlameableBehavior',
        ];
    }

}
