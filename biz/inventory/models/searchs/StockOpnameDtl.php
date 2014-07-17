<?php

namespace biz\inventory\models\searchs;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use biz\inventory\models\StockOpnameDtl as StockOpnameDtlModel;

/**
 * StockOpnameDtl represents the model behind the search form about `biz\inventory\models\StockOpnameDtl`.
 */
class StockOpnameDtl extends StockOpnameDtlModel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_opname'],'required'],
            [['id_opname', 'id_product', 'id_uom'], 'integer'],
            [['qty'], 'number'],
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
        $query = StockOpnameDtlModel::find()->with('products');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);
        if (!$this->validate()) {
            $query->where('1=0');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id_opname' => $this->id_opname,
            'id_product' => $this->id_product,
            'id_uom' => $this->id_uom,
            'qty' => $this->qty,
        ]);

        return $dataProvider;
    }
}
