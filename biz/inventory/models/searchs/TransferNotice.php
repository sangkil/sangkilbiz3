<?php

namespace biz\inventory\models\searchs;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use biz\inventory\models\TransferNotice as TransferNoticeModel;

/**
 * TransferNotice represents the model behind the search form about `biz\inventory\models\TransferNotice`.
 */
class TransferNotice extends TransferNoticeModel
{
    public function rules()
    {
        return [
            [['id_transfer', 'status', 'update_by', 'create_by'], 'integer'],
            [['notice_date', 'description', 'create_at', 'update_at'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = TransferNoticeModel::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id_transfer' => $this->id_transfer,
            'notice_date' => $this->notice_date,
            'status' => $this->status,
            'update_by' => $this->update_by,
            'create_by' => $this->create_by,
        ]);

        $query->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'create_at', $this->create_at])
            ->andFilterWhere(['like', 'update_at', $this->update_at]);

        return $dataProvider;
    }
}
