<?php

namespace biz\inventory\models\searchs;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use biz\inventory\models\Transfer as TransferModel;

/**
 * Transfer represents the model behind the search form about `biz\inventory\models\Transfer`.
 */
class Transfer extends TransferModel
{
    public function rules()
    {
        return [
            [['id_transfer', 'id_warehouse_source', 'id_warehouse_dest', 'status', 'create_by', 'update_by'], 'integer'],
            [['transfer_num', 'transfer_date', 'receive_date', 'create_at', 'update_at'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = TransferModel::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id_transfer' => $this->id_transfer,
            'id_warehouse_source' => $this->id_warehouse_source,
            'id_warehouse_dest' => $this->id_warehouse_dest,
            'transfer_date' => $this->transfer_date,
            'receive_date' => $this->receive_date,
            'status' => $this->status,
            'create_by' => $this->create_by,
            'update_by' => $this->update_by,
        ]);

        $query->andFilterWhere(['like', 'transfer_num', $this->transfer_num])
            ->andFilterWhere(['like', 'create_at', $this->create_at])
            ->andFilterWhere(['like', 'update_at', $this->update_at]);

        return $dataProvider;
    }
}
