<?php

namespace biz\master\models\searchs;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use biz\master\models\ProductGroup as ProductGroupModel;

/**
 * ProductGroup represents the model behind the search form about `biz\master\models\ProductGroup`.
 */
class ProductGroup extends ProductGroupModel
{
    public function rules()
    {
        return [
            [['id_group', 'create_by', 'update_by'], 'integer'],
            [['cd_group', 'nm_group', 'create_at', 'update_at'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = ProductGroupModel::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id_group' => $this->id_group,
            'create_by' => $this->create_by,
            'update_by' => $this->update_by,
        ]);

        $query->andFilterWhere(['like', 'cd_group', $this->cd_group])
            ->andFilterWhere(['like', 'nm_group', $this->nm_group])
            ->andFilterWhere(['like', 'create_at', $this->create_at])
            ->andFilterWhere(['like', 'update_at', $this->update_at]);

        return $dataProvider;
    }
}
