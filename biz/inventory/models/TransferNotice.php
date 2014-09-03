<?php

namespace biz\inventory\models;

use Yii;

/**
 * This is the model class for table "transfer_notice".
 *
 * @property integer $id_transfer
 * @property string $notice_date
 * @property string $description
 * @property integer $status
 * @property integer $update_by
 * @property integer $create_by
 * @property string $create_at
 * @property string $update_at
 *
 * @property string $nmStatus
 * @property string $noticeDate
 *
 * @property TransferNoticeDtl[] $transferNoticeDtls
 * @property Transfer $idTransfer
 * @method boolean|integer saveRelated(string $relation, array $data, array $options)
 */
class TransferNotice extends \yii\db\ActiveRecord
{
    const STATUS_CREATE = 1;
    const STATUS_UPDATE = 2;
    const STATUS_APPROVE = 3;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%transfer_notice}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_transfer', 'noticeDate', 'description', 'status'], 'required'],
            [['id_transfer', 'status'], 'integer'],
            [['notice_date'], 'safe'],
            [['description'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_transfer' => 'Id Transfer',
            'notice_date' => 'Notice Date',
            'description' => 'Description',
            'status' => 'Status',
            'update_by' => 'Update By',
            'create_by' => 'Create By',
            'create_at' => 'Create At',
            'update_at' => 'Update At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTransferNoticeDtls()
    {
        return $this->hasMany(TransferNoticeDtl::className(), ['id_transfer' => 'id_transfer'])
                ->indexBy('id_product');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdTransfer()
    {
        return $this->hasOne(Transfer::className(), ['id_transfer' => 'id_transfer']);
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
                'class' => 'mdm\converter\DateConverter',
                'attributes' => [
                    'noticeDate' => 'notice_date',
                ]
            ],
            'BizStatusConverter',
            'mdm\behaviors\ar\RelatedBehavior',
        ];
    }
}
