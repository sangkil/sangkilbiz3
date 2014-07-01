<?php

namespace biz\master\models\searchs;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use biz\master\models\ProductSupplier as ProductSupplierModel;

/**
 * ProductSupplier represents the model behind the search form about `biz\master\models\ProductSupplier`.
 */
class ProductSupplier extends ProductSupplierModel
{
    public function rules()
    {
        return [
            [['id_product', 'id_supplier', 'create_by', 'update_by'], 'integer'],
            [['create_at', 'update_at'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = ProductSupplierModel::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id_product' => $this->id_product,
            'id_supplier' => $this->id_supplier,
            'create_by' => $this->create_by,
            'update_by' => $this->update_by,
        ]);

        $query->andFilterWhere(['like', 'create_at', $this->create_at])
            ->andFilterWhere(['like', 'update_at', $this->update_at]);

        return $dataProvider;
    }
}
