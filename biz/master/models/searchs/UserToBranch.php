<?php

namespace biz\master\models\searchs;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use biz\master\models\UserToBranch as UserToBranchModel;

/**
 * UserToBranch represents the model behind the search form about `biz\models\UserToBranch`.
 */
class UserToBranch extends UserToBranchModel {

    public function rules() {
        return [
            [['id_branch', 'id_user', 'create_by', 'update_by'], 'integer'],
            [['create_at', 'update_at'], 'safe'],
        ];
    }

    public function scenarios() {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params) {
        $query = UserToBranchModel::find()->innerJoin('branch','branch.id_branch=user_to_branch.id_branch')->all();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id_branch' => $this->id_branch,
            'id_user' => $this->id_user,
        ]);
        
       
        $query->andWhere('branch.nm_branch LIKE :nm_branch', [':nm_branch'=>$this->nm_branch]);
        return $dataProvider;
    }

}
