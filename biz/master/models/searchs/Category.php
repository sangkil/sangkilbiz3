<?php

namespace biz\master\models\searchs;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use biz\master\models\Category as CategoryModel;

/**
 * Category represents the model behind the search form about `biz\master\models\Category`.
 */
class Category extends CategoryModel
{
    public function rules()
    {
        return [
            [['id_category', 'create_by', 'update_by'], 'integer'],
            [['cd_category', 'nm_category', 'create_at', 'update_at'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = CategoryModel::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id_category' => $this->id_category,
            'create_by' => $this->create_by,
            'update_by' => $this->update_by,
        ]);

        $query->andFilterWhere(['like', 'cd_category', $this->cd_category])
            ->andFilterWhere(['like', 'nm_category', $this->nm_category])
            ->andFilterWhere(['like', 'create_at', $this->create_at])
            ->andFilterWhere(['like', 'update_at', $this->update_at]);

        return $dataProvider;
    }
}
