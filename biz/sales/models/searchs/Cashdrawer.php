<?php

namespace biz\sales\models\searchs;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use biz\sales\models\Cashdrawer as CashdrawerModel;

/**
 * Cashdrawer represents the model behind the search form about `biz\sales\models\Cashdrawer`.
 */
class Cashdrawer extends CashdrawerModel
{
    public function rules()
    {
        return [
            [['id_cashdrawer', 'id_branch', 'cashier_no', 'id_user', 'status', 'create_by', 'update_by'], 'integer'],
            [['client_machine', 'create_at', 'update_at'], 'safe'],
            [['init_cash', 'close_cash', 'variants'], 'number'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = CashdrawerModel::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);
        if (!$this->validate()) {
            $query->where('1=0');

            return $dataProvider;
        }

        $query->andFilterWhere([
            'id_cashdrawer' => $this->id_cashdrawer,
            'client_machine' => $this->client_machine,
            'id_branch' => $this->id_branch,
            'cashier_no' => $this->cashier_no,
            'id_user' => $this->id_user,
            'init_cash' => $this->init_cash,
            'close_cash' => $this->close_cash,
            'variants' => $this->variants,
            'status' => $this->status,
            'create_at' => $this->create_at,
            'create_by' => $this->create_by,
            'update_at' => $this->update_at,
            'update_by' => $this->update_by,
        ]);

        return $dataProvider;
    }
}
