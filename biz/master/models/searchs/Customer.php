<?php

namespace biz\master\models\searchs;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use biz\master\models\Customer as CustomerModel;

/**
 * Customer represents the model behind the search form about `biz\master\models\Customer`.
 */
class Customer extends CustomerModel
{
    public function rules()
    {
        return [
            [['id_customer', 'update_by', 'create_by'], 'integer'],
            [['cd_customer', 'nm_customer', 'contact_name', 'contact_number', 'status', 'update_at', 'create_at'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = CustomerModel::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id_customer' => $this->id_customer,
            'update_by' => $this->update_by,
            'create_by' => $this->create_by,
        ]);

        $query->andFilterWhere(['like', 'cd_customer', $this->cd_customer])
            ->andFilterWhere(['like', 'nm_customer', $this->nm_customer])
            ->andFilterWhere(['like', 'contact_name', $this->contact_name])
            ->andFilterWhere(['like', 'contact_number', $this->contact_number])
            ->andFilterWhere(['like', 'status', $this->status])
            ->andFilterWhere(['like', 'update_at', $this->update_at])
            ->andFilterWhere(['like', 'create_at', $this->create_at]);

        return $dataProvider;
    }
}
