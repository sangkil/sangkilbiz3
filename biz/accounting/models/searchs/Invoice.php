<?php

namespace biz\accounting\models\searchs;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use biz\accounting\models\Invoice as InvoiceModel;

/**
 * Invoice represents the model behind the search form about `biz\accounting\models\Invoice`.
 */
class Invoice extends InvoiceModel
{
    public function rules()
    {
        return [
            [['id_invoice', 'invoice_type', 'id_vendor', 'status', 'create_by', 'update_by'], 'integer'],
            [['invoice_num', 'invoice_date', 'due_date', 'invoice_value', 'create_at', 'update_at'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = InvoiceModel::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);
        if (!$this->validate()) {
            $query->where('1=0');

            return $dataProvider;
        }

        $query->andFilterWhere([
            'id_invoice' => $this->id_invoice,
            'invoice_type' => $this->invoice_type,
            'invoice_date' => $this->invoice_date,
            'due_date' => $this->due_date,
            'id_vendor' => $this->id_vendor,
            'status' => $this->status,
            'create_by' => $this->create_by,
            'update_by' => $this->update_by,
        ]);

        $query->andFilterWhere(['like', 'invoice_num', $this->invoice_num])
            ->andFilterWhere(['like', 'invoice_value', $this->invoice_value])
            ->andFilterWhere(['like', 'create_at', $this->create_at])
            ->andFilterWhere(['like', 'update_at', $this->update_at]);

        return $dataProvider;
    }
}
