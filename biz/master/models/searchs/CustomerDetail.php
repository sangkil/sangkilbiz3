<?php

namespace biz\master\models\searchs;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use biz\master\models\CustomerDetail as CustomerDetailModel;

/**
 * CustomerDetail represents the model behind the search form about `biz\master\models\CustomerDetail`.
 */
class CustomerDetail extends CustomerDetailModel
{
    public function rules()
    {
        return [
            [['id_customer', 'id_distric', 'id_kab', 'id_kec', 'id_kel', 'create_by', 'update_by'], 'integer'],
            [['addr1', 'addr2', 'latitude', 'longtitude', 'create_at', 'update_at'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = CustomerDetailModel::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id_customer' => $this->id_customer,
            'id_distric' => $this->id_distric,
            'id_kab' => $this->id_kab,
            'id_kec' => $this->id_kec,
            'id_kel' => $this->id_kel,
            'create_by' => $this->create_by,
            'update_by' => $this->update_by,
        ]);

        $query->andFilterWhere(['like', 'addr1', $this->addr1])
            ->andFilterWhere(['like', 'addr2', $this->addr2])
            ->andFilterWhere(['like', 'latitude', $this->latitude])
            ->andFilterWhere(['like', 'longtitude', $this->longtitude])
            ->andFilterWhere(['like', 'create_at', $this->create_at])
            ->andFilterWhere(['like', 'update_at', $this->update_at]);

        return $dataProvider;
    }
}
