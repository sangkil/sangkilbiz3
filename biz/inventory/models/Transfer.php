<?php

namespace biz\inventory\models;

use Yii;

use biz\master\models\Warehouse;

/**
 * This is the model class for table "transfer".
 *
 * @property integer $id_transfer
 * @property string $transfer_num
 * @property integer $id_warehouse_source
 * @property integer $id_warehouse_dest
 * @property string $transfer_date
 * @property string $receive_date
 * @property integer $status
 * @property string $create_at
 * @property integer $create_by
 * @property string $update_at
 * @property integer $update_by
 *
 * @property string $nmStatus
 * @property string $transferDate
 * @property string $receiveDate
 *
 * @property Warehouse $idWarehouseSource
 * @property Warehouse $idWarehouseDest
 * @property TransferDtl[] $transferDtls
 * @property TransferNoticeDtl[] $transferNoticeDtls
 * @property TransferNotice $transferNotice
 */
class Transfer extends \yii\db\ActiveRecord
{
    const STATUS_DRAFT = 1;
    const STATUS_ISSUE = 2;
    const STATUS_DRAFT_RECEIVE = 3;
    const STATUS_CONFIRM = 4;
    const STATUS_CONFIRM_REJECT = 5;
    const STATUS_CONFIRM_APPROVE = 6;
    const STATUS_RECEIVE = 7;

    const SCENARIO_RECEIVE = 'receive';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%transfer}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_warehouse_source', 'id_warehouse_dest', 'transferDate', 'status'], 'required'],
            [['receiveDate'], 'required', 'on' => [self::SCENARIO_RECEIVE]],
            [['id_warehouse_source', 'id_warehouse_dest', 'status'], 'integer'],
            [['transfer_date', 'receive_date'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_transfer' => 'Id Transfer',
            'transfer_num' => 'Transfer Num',
            'id_warehouse_source' => 'Id Warehouse Source',
            'id_warehouse_dest' => 'Id Warehouse Dest',
            'transfer_date' => 'Transfer Date',
            'receive_date' => 'Receive Date',
            'status' => 'Status',
            'create_at' => 'Create At',
            'create_by' => 'Create By',
            'update_at' => 'Update At',
            'update_by' => 'Update By',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdWarehouseSource()
    {
        return $this->hasOne(Warehouse::className(), ['id_warehouse' => 'id_warehouse_source']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdWarehouseDest()
    {
        return $this->hasOne(Warehouse::className(), ['id_warehouse' => 'id_warehouse_dest']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTransferDtls()
    {
        return $this->hasMany(TransferDtl::className(), ['id_transfer' => 'id_transfer'])
        ->orderBy([new \yii\db\Expression('transfer_qty_send=0 ASC')]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTransferNotice()
    {
        return $this->hasOne(TransferNotice::className(), ['id_transfer' => 'id_transfer']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTransferNoticeDtls()
    {
        return $this->hasMany(TransferNoticeDtl::className(), ['id_transfer' => 'id_transfer'])->viaTable('transfer_notice', ['id_transfer' => 'id_transfer']);
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'BizTimestampBehavior',
            'BizBlameableBehavior',
            [
                'class' => 'mdm\autonumber\Behavior',
                'digit' => 6,
                'attribute' => 'transfer_num',
                'value' => 'IN' . date('y.?')
            ],
            [
                'class'=>'mdm\converter\DateConverter',
                'attributes' => [
                    'transferDate' => 'transfer_date',
                    'receiveDate' => 'receive_date'
                ]
            ],
            'BizStatusConverter',
            'mdm\behaviors\ar\RelationBehavior',
        ];
    }
}
