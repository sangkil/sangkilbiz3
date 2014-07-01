<?php

namespace biz\master\models\searchs;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use biz\master\models\Supplier as SupplierModel;

/**
 * Supplier represents the model behind the search form about `biz\master\models\Supplier`.
 */
class Supplier extends SupplierModel
{
    public function rules()
    {
        return [
            [['id_supplier', 'create_by', 'update_by'], 'integer'],
            [['cd_supplier', 'nm_supplier', 'create_at', 'update_at'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = SupplierModel::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id_supplier' => $this->id_supplier,
            'create_by' => $this->create_by,
            'update_by' => $this->update_by,
        ]);

        $query->andFilterWhere(['like', 'cd_supplier', $this->cd_supplier])
            ->andFilterWhere(['like', 'nm_supplier', $this->nm_supplier])
            ->andFilterWhere(['like', 'create_at', $this->create_at])
            ->andFilterWhere(['like', 'update_at', $this->update_at]);

        return $dataProvider;
    }
}
