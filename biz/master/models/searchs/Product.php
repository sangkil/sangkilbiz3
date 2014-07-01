<?php

namespace biz\master\models\searchs;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use biz\master\models\Product as ProductModel;

/**
 * Product represents the model behind the search form about `biz\master\models\Product`.
 */
class Product extends ProductModel
{
    public function rules()
    {
        return [
            [['id_product', 'id_category', 'id_group', 'create_by', 'update_by'], 'integer'],
            [['cd_product', 'nm_product', 'create_at', 'update_at'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = ProductModel::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id_product' => $this->id_product,
            'id_category' => $this->id_category,
            'id_group' => $this->id_group,
            'create_by' => $this->create_by,
            'update_by' => $this->update_by,
        ]);

        $query->andFilterWhere(['like', 'cd_product', $this->cd_product])
            ->andFilterWhere(['like', 'nm_product', $this->nm_product])
            ->andFilterWhere(['like', 'create_at', $this->create_at])
            ->andFilterWhere(['like', 'update_at', $this->update_at]);

        return $dataProvider;
    }
}
