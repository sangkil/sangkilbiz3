<?php

namespace biz\inventory\hooks;

use Yii;
use biz\app\Hooks;
use biz\inventory\models\TransferNotice;
use biz\inventory\models\TransferNoticeDtl;
use biz\app\base\Event;

/**
 * Description of CreateTransferNotice
 *
 * @author MDMunir
 */
class TransferNoticeHook extends \yii\base\Behavior
{

    public function events()
    {
        return [
            Hooks::E_IRREC_23 => 'receiveReceiveEnd',
        ];
    }

    /**
     *
     * @param Event $event
     */
    public function receiveReceiveEnd($event)
    {
        $model = $event->params[0];
        $noticeDtls = [];
        foreach ($model->transferDtls as $detail) {
            if ($detail->transfer_qty_send != $detail->transfer_qty_receive) {
                $noticeDtl = new TransferNoticeDtl;
                $noticeDtl->id_product = $detail->id_product;
                $noticeDtl->qty_notice = $detail->transfer_qty_receive - $detail->transfer_qty_send;
                $noticeDtl->id_uom = $detail->id_uom;
                $noticeDtls[] = $noticeDtl;
            }
        }
        if (count($noticeDtls)) {
            $notice = new TransferNotice;
            $notice->description = 'Qty kirim tidak sama dengan qty terima';
            $notice->notice_date = date('Y-m-d');
            $notice->status = TransferNotice::STATUS_CREATE;
            $notice->id_transfer = $model->id_transfer;
            if (!$notice->save()) {
                throw new \Exception(implode("\n", $notice->firstErrors));
            }
            Yii::$app->trigger(Hooks::E_TNCRE_21, new Event([$notice]));
            foreach ($noticeDtls as $noticeDtl) {
                $noticeDtl->id_transfer = $notice->id_transfer;
                if (!$noticeDtl->save()) {
                    throw new \Exception(implode("\n", $noticeDtl->firstErrors));
                }
                Yii::$app->trigger(Hooks::E_TNCRE_22, new Event([$notice, $noticeDtl]));
            }
            Yii::$app->trigger(Hooks::E_TNCRE_23, new Event([$notice]));
        }
    }
}
