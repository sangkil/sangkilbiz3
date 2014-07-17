<?php

namespace biz\inventory\models\searchs;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use biz\inventory\models\StockOpname as StockOpnameModel;

/**
 * StockOpname represents the model behind the search form about `biz\inventory\models\StockOpname`.
 */
class StockOpname extends StockOpnameModel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_opname', 'id_warehouse', 'status', 'create_by', 'update_by'], 'integer'],
            [['opname_num', 'opname_date', 'description', 'operator1', 'operator2', 'operator3', 'create_at', 'update_at'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = StockOpnameModel::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id_opname' => $this->id_opname,
            'id_warehouse' => $this->id_warehouse,
            'opname_date' => $this->opname_date,
            'status' => $this->status,
            'create_at' => $this->create_at,
            'create_by' => $this->create_by,
            'update_at' => $this->update_at,
            'update_by' => $this->update_by,
        ]);

        $query->andFilterWhere(['like', 'opname_num', $this->opname_num])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'operator1', $this->operator1])
            ->andFilterWhere(['like', 'operator2', $this->operator2])
            ->andFilterWhere(['like', 'operator3', $this->operator3]);

        return $dataProvider;
    }
}
