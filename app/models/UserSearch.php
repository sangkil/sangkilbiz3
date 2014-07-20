<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $auth_key
 * @property integer $role
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 *
 */

/**
 * UserSearh represents the model behind the search form about `app\models\User`.
 */
class UserSearch extends \app\models\User
{
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['username', 'password_hash', 'email', 'auth_key', 'role', 'status', 'created_at', 'updated_at', 'password'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = User::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
        ]);

        $query->andFilterWhere(['like', 'username', $this->username]);

        $query->addOrderBy(['id' => SORT_ASC]);

        return $dataProvider;
    }

}
