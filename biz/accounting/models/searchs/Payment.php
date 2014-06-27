<?php

namespace biz\accounting\models\searchs;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use biz\accounting\models\Payment as PaymentModel;

/**
 * Payment represents the model behind the search form about `biz\accounting\models\Payment`.
 */
class Payment extends PaymentModel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_payment', 'payment_type', 'create_by', 'update_by'], 'integer'],
            [['payment_num', 'payment_date', 'create_date', 'update_date'], 'safe'],
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
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = static::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id_payment' => $this->id_payment,
            'payment_type' => $this->payment_type,
            'payment_date' => $this->payment_date,
            'create_date' => $this->create_date,
            'create_by' => $this->create_by,
            'update_date' => $this->update_date,
            'update_by' => $this->update_by,
        ]);

        $query->andFilterWhere(['like', 'payment_num', $this->payment_num]);

        return $dataProvider;
    }
}
