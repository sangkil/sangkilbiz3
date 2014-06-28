<?php

namespace biz\inventory\components;

use biz\inventory\models\TransferHdr;
use biz\inventory\models\TransferNotice;

/**
 * Description of AccessHandler
 *
 * @author Misbahul D Munir (mdmunir) <misbahuldmunir@gmail.com>
 */
class AccessHandler extends \biz\app\base\AccessHandler
{

    protected function checkAction($user, $action, $model)
    {
        return true;
    }

    public function modelClasses()
    {
        return[
            TransferHdr::className(),
            TransferNotice::className()
        ];
    }
}