<?php

namespace biz\accounting\models;

use Yii;

/**
 * This is the model class for table "gl_detail".
 *
 * @property integer $id_gl_detail
 * @property integer $id_gl
 * @property integer $id_coa
 * @property double $amount
 * @property double $debit
 * @property double $kredit
 *
 * @property Coa $idCoa
 * @property GlHeader $idGl
 */
class GlDetail extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%gl_detail}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_gl', 'id_coa', 'amount'], 'required'],
            [['id_gl', 'id_coa'], 'integer'],
            [['amount'], 'number'],
            [['debit', 'kredit'], 'safe',]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_gl_detail' => 'Id Gl Detail',
            'id_gl' => 'Id Gl',
            'id_coa' => 'Id Coa',
            'amount' => 'Amount',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdCoa()
    {
        return $this->hasOne(Coa::className(), ['id_coa' => 'id_coa']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdGl()
    {
        return $this->hasOne(GlHeader::className(), ['id_gl' => 'id_gl']);
    }

    public function getDebit()
    {
        return $this->amount > 0 ? number_format($this->amount) : '';
    }

    public function getKredit()
    {
        return $this->amount < 0 ? number_format(-1*$this->amount) : '';
    }

    public function setDebit($value)
    {
        $number = explode('.', $value, 2);
        $value = str_replace(',', '', $number[0]) . (isset($number[1]) ? '.' . $number[1] : '');
        if ($value > 0.0) {
            $this->amount = $value;
        }
    }

    public function setKredit($value)
    {
        $number = explode('.', $value, 2);
        $value = str_replace(',', '', $number[0]) . (isset($number[1]) ? '.' . $number[1] : '');
        if ($value > 0.0) {
            $this->amount = -$value;
        }
    }
}
