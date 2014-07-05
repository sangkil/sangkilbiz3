<?php

namespace biz\accounting\hooks;

use biz\app\Hooks;
use biz\accounting\components\Helper as AccHelper;
use biz\accounting\models\GlHeader;
use biz\accounting\models\GlDetail;
use yii\base\UserException;

/**
 * Description of Gl
 *
 * @author MDMunir
 */
class GlHook extends \yii\base\Behavior
{

    public function events()
    {
        return [
            Hooks::E_PPREC_23 => 'purchaseReceiveEnd'
        ];
    }

    /**
     * 
     * @param \biz\base\Event $event
     */
    public function purchaseReceiveEnd($event)
    {
        /* @var $model \biz\accounting\models\Purchase */
        $model = $event->params[0];
        // GL *************
        $glHdr = [
            'date' => date('Y-m-d'),
            'type_reff' => GlHeader::TYPE_PURCHASE,
            'memo' => null,
            'id_reff' => $model->id_purchase,
            'id_branch' => $model->id_branch,
            'description' => 'Pembelian barang kredit ' . $model->purchase_num,
        ];

        $dtls = [
            'PERSEDIAAN' => $model->purchase_value * (1 - $model->item_discount * 0.01),
            'HUTANG' => $model->purchase_value * (1 - $model->item_discount * 0.01),
        ];

        $glDtls = AccHelper::entriSheetToGlMaps('PEMBELIAN_KREDIT', $dtls);
        AccHelper::createGL($glHdr, $glDtls);
    }
}