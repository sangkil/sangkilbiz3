<?php

namespace biz\master\models\searchs;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use biz\master\models\Branch as BranchModel;

/**
 * Branch represents the model behind the search form about `biz\master\models\Branch`.
 */
class Branch extends BranchModel
{
    public function rules()
    {
        return [
            [['id_branch', 'id_orgn', 'create_by', 'update_by'], 'integer'],
            [['cd_branch', 'nm_branch', 'create_at', 'update_at'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = BranchModel::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id_branch' => $this->id_branch,
            'id_orgn' => $this->id_orgn,
            'create_by' => $this->create_by,
            'update_by' => $this->update_by,
        ]);

        $query->andFilterWhere(['like', 'cd_branch', $this->cd_branch])
            ->andFilterWhere(['like', 'nm_branch', $this->nm_branch])
            ->andFilterWhere(['like', 'create_at', $this->create_at])
            ->andFilterWhere(['like', 'update_at', $this->update_at]);

        return $dataProvider;
    }
}
