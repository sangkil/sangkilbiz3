<?php

namespace biz\master\models\searchs;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use biz\master\models\UserToBranch as UserToBranchModel;

/**
 * UserToBranch represents the model behind the search form about `biz\models\UserToBranch`.
 */
class UserToBranch extends UserToBranchModel
{
    public function rules()
    {
        return [
            [['id_branch', 'id_user', 'create_by', 'update_by'], 'integer'],
            [['create_date', 'update_date'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = UserToBranchModel::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id_branch' => $this->id_branch,
            'id_user' => $this->id_user,
            'is_active' => $this->is_active,
            'create_date' => $this->create_date,
            'create_by' => $this->create_by,
            'update_date' => $this->update_date,
            'update_by' => $this->update_by,
        ]);

        return $dataProvider;
    }
}
