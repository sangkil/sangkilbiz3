<?php

namespace biz\sales\models\searchs;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use biz\sales\models\Sales as SalesModel;

/**
 * Sales represents the model behind the search form about `biz\sales\models\Sales`.
 */
class Sales extends SalesModel
{
    public function rules()
    {
        return [
            [['id_sales', 'id_branch', 'id_customer', 'id_cashdrawer', 'status', 'create_by', 'update_by'], 'integer'],
            [['sales_num', 'discount', 'sales_date', 'create_at', 'update_at'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = SalesModel::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id_sales' => $this->id_sales,
            'id_branch' => $this->id_branch,
            'id_customer' => $this->id_customer,
            'id_cashdrawer' => $this->id_cashdrawer,
            'sales_date' => $this->sales_date,
            'status' => $this->status,
            'create_by' => $this->create_by,
            'update_by' => $this->update_by,
        ]);

        $query->andFilterWhere(['like', 'sales_num', $this->sales_num])
            ->andFilterWhere(['like', 'discount', $this->discount])
            ->andFilterWhere(['like', 'create_at', $this->create_at])
            ->andFilterWhere(['like', 'update_at', $this->update_at]);

        return $dataProvider;
    }
}
