<?php

namespace biz\inventory\models;

use Yii;
use biz\master\models\Product;
use biz\master\models\Uom;
use biz\master\models\ProductUom;

/**
 * This is the model class for table "transfer_dtl".
 *
 * @property integer $id_transfer
 * @property integer $id_product
 * @property string $transfer_qty_send
 * @property string $transfer_qty_receive
 * @property integer $id_uom
 *
 * @property Uom $idUom
 * @property Product $idProduct
 * @property Transfer $idTransfer
 * @property TransferNoticeDtl $transferNoticeDtl Description
 */
class TransferDtl extends \yii\db\ActiveRecord
{
    public $id_warehouse;
    public $id_uom_trans;
    public $qty_trans;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%transfer_dtl}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_transfer', 'id_product', 'id_uom'], 'required'],
            [['transfer_qty'], 'required', 'on' => Transfer::SCENARIO_DEFAULT],
            [['id_transfer', 'id_product', 'id_uom'], 'integer'],
            [['transfer_qty', 'transfer_qty_send', 'transfer_qty_receive'], 'number'],
            [['qty_trans'], 'convertQty', 'on' => [Transfer::SCENARIO_RELEASE, Transfer::SCENARIO_RECEIVE]],
            [['id_warehouse'], 'require', 'when' => function($model) {
                return $model->qty_trans !== null && $model->qty_trans !== '';
            }, 'on' => [Transfer::SCENARIO_RELEASE, Transfer::SCENARIO_RECEIVE]]
        ];
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();

        foreach ($scenarios[Transfer::SCENARIO_RELEASE] as $i => $attr) {
            if (!in_array($attr, ['id_warehouse', 'qty_trans', 'id_uom_trans']) && $attr[0] != '!') {
                $scenarios[Transfer::SCENARIO_RELEASE][$i] = '!' . $attr;
            }
        }
        foreach ($scenarios[Transfer::SCENARIO_RECEIVE] as $i => $attr) {
            if (!in_array($attr, ['id_warehouse', 'qty_trans', 'id_uom_trans']) && $attr[0] != '!') {
                $scenarios[Transfer::SCENARIO_RECEIVE][$i] = '!' . $attr;
            }
        }
        return $scenarios;
    }

    public function convertQty($attribute)
    {
        $scenario = $this->scenario;
        $field = $scenario == Transfer::SCENARIO_RELEASE ? 'transfer_qty_send' : 'transfer_qty_receive';
        if ($this->id_uom_trans === null || $this->id_uom == $this->id_uom_trans) {
            $this->$field += $this->qty_trans;
        } else {
            $uoms = ProductUom::find()->where(['id_product' => $this->id_product])->indexBy('id_uom')->all();
            $this->$field += $this->qty_trans * $uoms[$this->id_uom_trans]->isi / $uoms[$this->id_uom]->isi;
        }
        if ($scenario == Transfer::SCENARIO_RELEASE && $this->transfer_qty_send > $this->transfer_qty) {
            $this->addError($attribute, 'Total qty release large than transfer qty');
        }
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_transfer' => 'Id Transfer',
            'id_product' => 'Id Product',
            'transfer_qty_send' => 'Transfer Qty Send',
            'transfer_qty_receive' => 'Transfer Qty Receive',
            'id_uom' => 'Id Uom',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdUom()
    {
        return $this->hasOne(Uom::className(), ['id_uom' => 'id_uom']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdProduct()
    {
        return $this->hasOne(Product::className(), ['id_product' => 'id_product']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdTransfer()
    {
        return $this->hasOne(Transfer::className(), ['id_transfer' => 'id_transfer']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTransferNoticeDtl()
    {
        return $this->hasOne(TransferNoticeDtl::className(), ['id_transfer' => 'id_transfer', 'id_product' => 'id_product']);
    }
}